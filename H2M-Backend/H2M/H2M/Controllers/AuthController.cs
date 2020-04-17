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

        [Route("~/login/{email}/{password}")]
        [HttpGet(Name = "Get")]
        public Response Get(string email, string password)
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
                return new Response()
                            {
                                Code = (int)HttpStatusCode.InternalServerError,
                                Data = "Internal server error"
                            };

            }
        }
    }
}
