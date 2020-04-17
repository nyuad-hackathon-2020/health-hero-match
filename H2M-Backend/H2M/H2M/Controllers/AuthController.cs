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
    }
}
