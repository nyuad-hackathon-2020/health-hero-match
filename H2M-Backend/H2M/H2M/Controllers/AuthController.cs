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
    }
}
