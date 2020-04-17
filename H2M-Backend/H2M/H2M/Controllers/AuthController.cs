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

namespace H2M.Controllers
{
    [Route("api/[controller]")]
    [ApiController]
    public class AuthController : ControllerBase
    {

        // GET: api/Auth/5
        Response InternalErrorObj= new Response() {Code = (int)HttpStatusCode.InternalServerError,Data = "Internal server error"};
        [Route("~/login")]
        [HttpPost]
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
        public Response Signup([FromForm]string Email,[FromForm]string Password,[FromForm] string Gender,[FromForm] string Name, [FromForm] double? Longitude, [FromForm] double? Latitude, [FromForm] int? CountryId, [FromForm] int? CityId, [FromForm] int? RoleId)
        {
            try
            {
                using (var db=new H2MDbContext())
                {
                    var newUser = new User()
                    {
                        Email = Email.Trim(),
                        Password = Password,
                        RoleId = RoleId??0,
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
        [HttpPost]
        public Response GetRequestsSorted([FromForm]string lang,[FromForm]string lat)
        {
            using (var db = new H2MDbContext()){

                var _hospitals = db.Hospital.ToList();
                if (_hospitals.Count == 0)
                {
                    return new Response()
                    {
                        Code = (int)HttpStatusCode.OK,
                        Data = "No Hospitals found"
                    };

                }

                foreach (Hospital h in _hospitals)
                {

                }

                return new Response()
                {
                    Code = (int)HttpStatusCode.OK,
                    Data = authObj
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
        [HttpPost]
        public Response CheckPeak([FromForm] int HospitalID){
            try
            {
                bool isPeak = false;
                using (var db = new H2MDbContext())
                {
                    var hospital = db.User.Include(h => h.City).Where(h => h.Id == HospitalID).FirstOrDefault();
                    var city = hospital.City;
                    //var init = d

                    return new Response()
                    {
                        Code = (int)HttpStatusCode.OK,
                        Data = isPeak
                    };
                }

            }
            catch (Exception ex)
            {
                throw new Exception("Server Error");
            }

        }
        private async void getData()
        {
            //http://coronavirusapi.com/getTimeSeriesJson/NY

            var uri = new Uri("http://www.example.com/");
            var hc = new HttpClient();
            var result = await hc.GetStringAsync(uri);



        }

    }
}
