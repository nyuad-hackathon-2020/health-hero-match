using System;
using H2M.Models;
using System.Collections.Generic;
using System.Linq;
using Microsoft.EntityFrameworkCore;
namespace H2M.Controllers
{
    public class AuthHelper
    {
        public static bool CheckIfTokenIsValid(H2MDbContext db, AuthObject auth)
        {
            var yesterday = DateTime.Now.AddDays(-1);
            var _token = db.Tokens.Where(token => token.UserId == auth.UserId && token.Token==auth.Token && token.ExpiryDate >= yesterday).FirstOrDefault();
            return _token == null;
        }
        public static AuthObject CreateToken(H2MDbContext db, User user,string roleName)
        {
            var yesterday = DateTime.Now.AddDays(-1);
            var _token = db.Tokens.Where(token => token.UserId == user.Id && token.ExpiryDate >= yesterday).FirstOrDefault();
            Tokens new_token = null;
            if (_token == null)
            {
                var exp = DateTime.Now.AddDays(30);
                new_token = new Tokens()
                {
                    CreationDate=DateTime.Now,
                    ExpiryDate =exp,
                    Token = Guid.NewGuid().ToString(),
                    RoleId = user.RoleId,
                    UserId = user.Id
                };
                db.Tokens.Add(new_token);
                db.SaveChanges();
            }
            else
            {
                new_token = _token;
            }
            var authObj = new AuthObject()
            {
                Role = roleName,
                Token = new_token.Token,
                UserId = user.Id
            };
            return authObj;
        }

        public class AuthObject
        {
            public string Token { get; set; }
            public int UserId { get; set; }
            public string Role { get; set; }
        }
    }
}