using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using H2M.Models;
using Newtonsoft.Json;
using System.Net;
using Microsoft.EntityFrameworkCore;
using System.Net.Http;
using Newtonsoft.Json;
using H2M.ViewModels;

namespace H2M.Controllers
{
    [Route("api/[controller]")]
    [ApiController]
    public class AuthController : ControllerBase
    {

        // GET: api/Auth/5
        Response InternalErrorObj= new Response() {Code = (int)HttpStatusCode.InternalServerError,Data = "Internal server error"};
        [Route("~/login")]
        [HttpGet]
        public Response Login([FromForm]string email, [FromForm] string password)
        {
            try
            {
                using (var db = new H2MDbContext())
                {
                    email = email.Trim();
                    var _user = db.User.Include(user => user.Role).Where(user => user.Email.Trim() == email && user.Password == password).FirstOrDefault();
                    if (_user == null)
                    {
                        return new Response()
                            {
                                Code = (int)HttpStatusCode.Unauthorized,
                                Data = "Incorrect email or password!"
                            };
                    }
                    AuthHelper.AuthObject authObj = AuthHelper.CreateToken(db, _user, _user.Role.Name);
                    return new Response()
                    {
                        Code = (int)HttpStatusCode.OK,
                        Data = authObj
                    };
                }
            }
            catch (Exception ex)
            {
                return InternalErrorObj;
            }
        }
        
        [Route("~/signup")]
        public Response Signup([FromForm]string Email,[FromForm]string Password,[FromForm] string Gender,[FromForm] string Name, [FromForm] double? Longitude, [FromForm] double? Latitude, [FromForm] int? CountryId, [FromForm] int? CityId, [FromForm] int? RoleId,[FromForm] string SpecialitiesJson)
        {
            try
            {
                using (var db=new H2MDbContext())
                {
                    
                    var roleId = (RoleId ?? 0);
                    var newUser = new User()
                    {
                        Email = Email.Trim(),
                        Password = Password,
                        RoleId = roleId,
                        DateCreated = DateTime.Now,
                        Gender = Gender,
                        Name = Name.Trim(),
                        CountryId=CountryId??-1,
                        CityId=CityId??-1,
                        Longitude=Longitude,
                        Latitude=Latitude
                    };
                    db.SaveChanges();
                    var authObject = AuthHelper.CreateToken(db, newUser, newUser.Role.Name);
                    List<Speciality> specs=null;
                    if (!string.IsNullOrWhiteSpace(SpecialitiesJson))
                    {
                        specs = JsonConvert.DeserializeObject<List<Speciality>>(SpecialitiesJson);
                    }
                    if (roleId== 1)
                    {
                        var _hospital = new Hospital()
                        {
                            Id=newUser.Id,
                            Latitude=Latitude,
                            Longitude=Longitude
                        };
                        db.Hospital.Add(_hospital);
                        db.SaveChanges();

                    }else if (roleId == 2)
                    {
                        var _doctor = new Doctor()
                        {
                            DoctorId = newUser.Id.ToString()
                        };
                        specs.ForEach(s => _doctor.DoctorSpeciality.Add(new DoctorSpeciality()
                        {
                            Speciality=s,
                            DoctorId=newUser.Id
                        }));
                        db.Doctor.Add(_doctor);
                        db.SaveChanges();
                    }
                    else if(roleId==3)
                    {
                        var _nurse = new Nurse()
                        {
                            NurseId = newUser.Id.ToString()
                        };
                        specs.ForEach(s => _nurse.NurseSpeciality.Add(new NurseSpeciality()
                        {
                            Speciality = s,
                            NurseId= newUser.Id
                        }));
                        db.Nurse.Add(_nurse);
                        db.SaveChanges();
                    }
                    else
                    {
                        InternalErrorObj.Data = "Invalid Job";
                        return InternalErrorObj;
                    }
                    return new Response()
                    {
                        Code = (int)HttpStatusCode.OK,
                        Data = authObject
                    };
                }
            }
            catch (Exception ex)
            {
                return InternalErrorObj;
            }
        }

        [Route("~/GetRequestsSorted")]
        [HttpGet]
        public async Task<Response> GetRequestsSorted(double? lon, double? lat, int docID)
        {
            using (var db = new H2MDbContext()) {
                var specIDs = db.DoctorSpeciality.Where(doc => doc.DoctorId == docID).ToList();
                List<int> specs = new List<int>();

                foreach (DoctorSpeciality doc in specIDs)
                {
                    specs.Add(doc.SpecialityId);
                }
                //var spec = db.Doctor.Include(u => u.DoctorSpeciality).Where(d => d.DoctorId);
                var employeeRequested = db.EmployeeRequest.Where(a => a.UserId == docID).Select(a => a.RequestId).ToList();

                var _hospitals = db.HostpitalRequest.Include(h => h.Hospital).Include(a => a.Hospital.IdNavigation).Include(a => a.Hospital.IdNavigation.City).Include(a => a.Hospital.IdNavigation.Country).Include(h => h.Speciality).Where(a=>a.Enabled).ToList();
                //added where to only show enabled requests
                List<RequestViewModel> result = new List<RequestViewModel>();

                User user = null;
                if (lon == null || lat == null)
                    user = db.User.Where(a => a.Id == docID).FirstOrDefault();
                foreach (HostpitalRequest h in _hospitals)
                {
                    double distance = 0;
                    if (lon != null && lat != null)
                        distance = GetDistance(h.Hospital.Latitude.Value, h.Hospital.Longitude.Value, (double)lat, (double)lon);
                    else
                    {
                        distance = user.CityId == h.Hospital.IdNavigation.CityId ? 11111 : 111111;
                    }
                    bool isPeak = await getPeak(h.Hospital.IdNavigation.City.Initals);
                    result.Add(new RequestViewModel
                    {
                        Request = new { speciality = h.Speciality.Name, hospitalName = h.Hospital.IdNavigation.Name, count = h.Count, country = h.Hospital.IdNavigation.Country.Name, city = h.Hospital.IdNavigation.City.Name, hospitalAppId = h.Id, isApplied = employeeRequested.Contains(h.Id), isPeak },
                        Distance = distance
                    });
                }
                result.Sort((p, q) => p.Distance.CompareTo(q.Distance));

                return new Response()
                {
                    Code = (int)HttpStatusCode.OK,
                    Data = result
                };
            }
        }


        [Route("~/GetHospital")]
        public async Task<Response> GetHospital(int ID)
        {
            try
            {
                using (var db = new H2MDbContext())
                {

                    var hospitalInfo = db.User.Where(h => h.Id == ID).Select(a => new { a.Email, a.Name, City = a.City.Name, Country = a.Country.Name, Initls = a.City.Initals}).FirstOrDefault();

                    var requests = db.HostpitalRequest.Where(r => r.HospitalId == ID).Select(a => new { a.Id, a.Speciality, a.Enabled, a.Count }).ToList();

                    bool isPeak = await getPeak(hospitalInfo.Initls);

                    List<int> ids = new List<int>();
                    List<int> leftPos = new List<int>();
                    foreach(var r in requests)
                    {
                        var requestLeft = db.EmployeeRequest.Where(a => a.RequestId == r.Id && a.Status == 1).ToList().Count;
                        leftPos.Add(requestLeft);
                        ids.Add(r.Id);
                    }
                    /*
                     'id' => $request['id'],
            'userName' => $request['user']['name'],
            'status' => $request['status'],
            'time' => $new_date,
            'speciality' => $request['speciality']['name']
                     */
                    var newRequests = db.EmployeeRequest.Where(r => ids.Contains(r.RequestId)).Select(r => new { User=new {r.User.Name}, r.Status, r.Time, Speciality=new { r.Request.Speciality.Name }, r.Id,r.RequestId}).ToList();

                    newRequests.Reverse();
                    requests.Reverse();

                    //var newReuests = db.EmployeeRequest.Where(r => r.);

                    return new Response()
                    {
                        Code = (int)HttpStatusCode.OK,
                        Data = new {hospitalInfo, requests , leftPos, newRequests , isPeak }
                    };
                }
            }
            catch (Exception ex)
            {
                return new Response()
                {
                    Code = (int)HttpStatusCode.InternalServerError,
                    Data = ex.ToString()
                };

            }

        }
        private double GetDistance(double prmLat1, double prmLon1, double prmLat2, double prmLon2)
        {
            try
            {
                double theta = prmLon1 - prmLon2;
                double dist = Math.Sin(deg2rad(prmLat1)) * Math.Sin(deg2rad(prmLat2)) + Math.Cos(deg2rad(prmLat1)) * Math.Cos(deg2rad(prmLat2)) * Math.Cos(deg2rad(theta));
                dist = Math.Acos(dist);
                dist = rad2deg(dist);
                dist = dist * 60 * 1.1515;
                dist = dist * 1.609344;
                return Math.Round(dist, 2);
            }
            catch (Exception ex)
            {
                throw new Exception("Server Error");
            }
        }

        private double rad2deg(double prmRad)
        {
            try
            {
                return (prmRad / Math.PI * 180.0);
            }
            catch (Exception ex)
            {
                throw new Exception("Server Error");
            }
        }

        private double deg2rad(double prmdeg)
        {
            try
            {
                return (prmdeg * Math.PI / 180.0);
            }
            catch (Exception ex)
            {
                throw new Exception("Server Error");
            }
        }

        [Route("~/CheckPeak")]
        [HttpGet]
        public async Task<Response> CheckPeak(int HospitalID){
            try
            {
                bool isPeak = false;
                using (var db = new H2MDbContext())
                {
                    var hospital = db.User.Include(c => c.City).Where(h => h.Id == HospitalID).FirstOrDefault();
                    var init = hospital.City.Initals;
                    //var result = await getData("MA");
                    var result = await getData(init);
                    var data = JsonConvert.DeserializeObject<List<Dictionary<String, dynamic>>>(result);
                    //double percent = 0;
                    double sum = 0;
                    List<double> nums = new List<double>();
                    nums.Add(0);
                    for (int i = data.Count - 1; i >= Math.Max(data.Count - 14, 0); i--)
                    {
                        sum += data[i]["positive"] - data[i-1]["positive"];
                        nums.Add(data[i]["positive"] - data[i - 1]["positive"]);
                    }

                    sum /= Math.Min(data.Count, 14);                       
                    var lastDay = data[data.Count - 1]["positive"] - data[data.Count - 2]["positive"];
                    if (lastDay >= (sum - sum*0.1))
                    {
                        isPeak = true;
                    }
                    sum = (sum - sum * 0.1);
                    return new Response()
                    {
                        Code = (int)HttpStatusCode.OK,
                        Data = new { isPeak , sum , init, lastDay, nums}
                    };
                }

            }
            catch (Exception ex)
            {
                throw new Exception("Server Error " + ex.ToString());
            }

        }
        private async Task<string> getData(string initals)
        {
            //http://coronavirusapi.com/getTimeSeriesJson/NY

            var uri = new Uri("http://coronavirusapi.com/getTimeSeriesJson/" + initals);
            var hc = new HttpClient();
            var result = await hc.GetStringAsync(uri);
            return result;
        }

        private async Task<bool> getPeak(String initls)
        {
            var result = await getData(initls);
            var data = JsonConvert.DeserializeObject<List<Dictionary<String, dynamic>>>(result);
            //double percent = 0;
            double sum = 0;
            List<double> nums = new List<double>();
            nums.Add(0);
            for (int i = data.Count - 1; i >= Math.Max(data.Count - 14, 0); i--)
            {
                sum += data[i]["positive"] - data[i - 1]["positive"];
                nums.Add(data[i]["positive"] - data[i - 1]["positive"]);
            }

            sum /= Math.Min(data.Count, 14);
            var lastDay = data[data.Count - 1]["positive"] - data[data.Count - 2]["positive"];
            if (lastDay >= (sum - sum * 0.1))
            {
                return true;
            }

            return false;

        }

    }
}
