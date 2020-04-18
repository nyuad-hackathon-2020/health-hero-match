using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using H2M.Models;
using System.Net;
using Microsoft.EntityFrameworkCore;
namespace H2M.Controllers
{
    [Route("api/[controller]")]
    [ApiController]
    public class DataController : ControllerBase
    {
        // GET: api/Data
        [Route("~/countries")]
        [HttpGet]
        public List<Country> Countries()
        {
            using (var db=new H2MDbContext())
            {
                return db.Country.ToList();
            }
        }

        [Route("~/ApplyList")]
        [HttpGet]
        public List<HostpitalRequest> ApplyList(int hospitalID)
        {
            using (var db = new H2MDbContext())
            {
                return db.HostpitalRequest.Where(a=>a.HospitalId== hospitalID).ToList();
            }
        }
        [Route("~/cities")]
        [HttpGet]
        public List<City> Cities()
        {
            using (var db = new H2MDbContext())
            {
                return db.City.ToList();
            }
        }
        [Route("~/Application")]
        [HttpGet]
        public dynamic Application(int RequestId)
        {
            using (var db = new H2MDbContext())
            {
                return db.HostpitalRequest.Where(a=>a.Id==RequestId&&a.Enabled).Select(a=>new { a.Count,a.Htmlpost,HospitalName=a.Hospital.IdNavigation.Name,SpecialityName=a.Speciality.Name,email=a.Hospital.IdNavigation.Email }).FirstOrDefault();
            }
        }
        [Route("~/MyProfile")]
        [HttpGet]
        public dynamic Profile(int userId)
        {
            using (var db = new H2MDbContext())
            {
                var userInfo = db.User.Where(a => a.Id == userId).Select(a => new { a.Email, a.Name , City = a.City.Name, Country = a.Country.Name}).FirstOrDefault();
                var specialtiesList = db.DoctorSpeciality.Where(a => a.DoctorId == userId).Select(a => a.Speciality.Name).ToList();
                return new { userInfo, specialtiesList };
            }
        }

        [Route("~/ApplicationHospital")]
        [HttpGet]
        public dynamic ApplicationHospital(int RequestId)
        {
            using (var db = new H2MDbContext())
            {
                return db.EmployeeRequest.Where(a => a.RequestId == RequestId&&a.Status!=0);
            }
        }
        [Route("~/ApproveRejectApplications")]
        [HttpGet]
        public dynamic ApproveRejectApplications(int EmployeeRequestId)
        {
            using (var db = new H2MDbContext())
            {
                var employee = db.EmployeeRequest.Include(a => a.Request).Include(a => a.User).Where(a => a.Id==EmployeeRequestId).FirstOrDefault();
                return employee;
            }
        }
        [Route("~/apply")]
        [HttpGet]
        public Response Apply(int EmployeeId,int RequestId)
        {
            try
            {
                using (var db = new H2MDbContext())
                {
                    EmployeeRequest er = new EmployeeRequest()
                    {
                        UserId = EmployeeId,
                        Time = DateTime.Now,
                        RequestId = RequestId,
                        Status = 0
                    };//0-> pending 1-> accepted -1-> rejected
                    db.EmployeeRequest.Add(er);
                    db.SaveChanges();
                }
                return new Response() { Code = (int)HttpStatusCode.OK, Data = "Applied Successfully" };
            }
            catch (Exception ex)
            {
                return new Response() { Code = (int)HttpStatusCode.InternalServerError, Data = "Something wrong happend. Can you please try agian?" };
            }
        }
    }
}
