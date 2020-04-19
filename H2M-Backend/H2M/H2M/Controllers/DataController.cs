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
        [Route("~/EmployeeRequests")]
        [HttpGet]
        public object EmployeeRequests(int userId)
        {
            using (var db = new H2MDbContext())
            {
                return db.EmployeeRequest.Include(a=>a.Request).Include(a=>a.Request.Hospital.IdNavigation).Where(a => a.UserId == userId).Select(a=>new { a.Request,a.Request.Hospital.IdNavigation.Name }).ToList();
            }
        }
        [Route("~/countries")]
        [HttpGet]
        public List<Country> Countries()
        {
            using (var db=new H2MDbContext())
            {
                return db.Country.ToList();
            }
        }
        [Route("~/NewDemand")]
        [HttpPost]
        public Response NewDemand([FromForm]int HospitalId,[FromForm] int count,[FromForm]string htmlPost,[FromForm] int SpecialityId)
        {
            using (var db = new H2MDbContext())
            {
                var request = new HostpitalRequest
                {
                    Count = count,
                    Htmlpost = htmlPost,
                    HospitalId = HospitalId,
                    SpecialityId = SpecialityId,
                    Enabled=true
                };
                db.HostpitalRequest.Add(request);
                db.SaveChanges();
                return new Response()
                {
                    Code = (int)HttpStatusCode.OK,
                    Data = "Demand added successfully!"
                };
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
        [Route("~/specialities")]
        [HttpGet]
        public dynamic specialities()
        {
            using (var db = new H2MDbContext())
            {
                return db.Speciality.Select(a=>new {a.Name,a.Id }).ToList();
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
                return db.HostpitalRequest.Where(a=>a.Id==RequestId&&a.Enabled).Select(a=>new { a.Count,a.Htmlpost,HospitalName=a.Hospital.IdNavigation.Name,SpecialityName=a.Speciality.Name,email=a.Hospital.IdNavigation.Email,a.Hospital.IdNavigation.Latitude,a.Hospital.IdNavigation.Longitude }).FirstOrDefault();
            }
        }
        [Route("~/MyProfile")]
        [HttpGet]
        public dynamic Profile(int userId)
        {
            using (var db = new H2MDbContext())
            {
                var userInfo = db.User.Where(a => a.Id == userId).Select(a => new { a.Name, a.City, a.Country, a.Email, a.Id}).FirstOrDefault();

                var specialtiesList = db.DoctorSpeciality.Where(a => a.DoctorId == userId).Select(a => a.Speciality.Name).ToList();

                var requests = db.EmployeeRequest.Where(a => a.UserId == userInfo.Id).Select( a => new { a.Status, a.Request.Hospital.IdNavigation.Name, a.Time}).ToList();
                requests.Reverse();

                return new { 
                    userInfo, specialtiesList, requests
                };
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
        [Route("~/AcceptRejectApplications")]
        [HttpGet]
        public dynamic ApproveRejectApplications(int EmployeeRequestId,bool AcceptOrDecline)
        {
            using (var db = new H2MDbContext())
            {
                var employeeRequest = db.EmployeeRequest.Include(a => a.Request).Include(a => a.User).Where(a => a.Id==EmployeeRequestId).FirstOrDefault();
                if (employeeRequest == null)
                {
                    return new Response()
                    {
                        Code = (int)HttpStatusCode.NotFound,
                        Data = "Invalid Request"
                    };
                }
                else
                {
                    var msg = "";
                    var userInfo = db.User.Where(a => a.Id == employeeRequest.UserId).FirstOrDefault();

                    var request = db.HostpitalRequest.Where(a => a.Id == employeeRequest.RequestId).FirstOrDefault();

                    if (AcceptOrDecline)
                    {
                        employeeRequest.Status = 1;
                        msg = userInfo.Name+ " accepted Successfully!";

                    }
                    else
                    {
                        employeeRequest.Status = -1;
                        msg = userInfo.Name+ " has been rejected.";
                    }
                    db.SaveChanges();
                    return new Response() { Code = (int)HttpStatusCode.OK, Data = new { userInfo.Name, userInfo.Email, msg } };
                }
            }
        }
                
        
        [Route("~/CancelHospitalRequest")]
        [HttpGet]
        public dynamic CancelHospitalRequest(int requestId)
        {
            using (var db = new H2MDbContext())
            {
                var employeeRequest = db.HostpitalRequest.Include(a => a.Enabled).Where(a => a.Id == requestId).FirstOrDefault();

                if (employeeRequest == null)
                {
                    return new Response()
                    {
                        Code = (int)HttpStatusCode.NotFound,
                        Data = "Invalid Request"
                    };
                }
                else
                {
                    employeeRequest.Enabled = false;
                    string msg = "Canelled Successfully!";
                    db.SaveChanges();
                    return new Response() { Code = (int)HttpStatusCode.OK, Data = new { msg } };
                }
            }
        }


        [Route("~/CancelDoctorRequest")]
        [HttpGet]
        public dynamic CancelDoctorRequest(int requestId)
        {
            using (var db = new H2MDbContext())
            {
                var employeeRequest = db.EmployeeRequest.Include(a => a.Status).Where(a => a.Id == requestId).FirstOrDefault();
                if (employeeRequest == null)
                {
                    return new Response()
                    {
                        Code = (int)HttpStatusCode.NotFound,
                        Data = "Invalid Request"
                    };
                }
                else
                {
                    employeeRequest.Status = -1;
                    string msg = "Canelled Successfully!";
                    db.SaveChanges();
                    return new Response() { Code = (int)HttpStatusCode.OK, Data = new { msg } };
                }
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
                    var HasApplied = db.EmployeeRequest.Where(a => a.UserId == EmployeeId && a.RequestId == RequestId).FirstOrDefault() != null;
                    if (HasApplied)
                    {
                          return new Response() { Code = (int)HttpStatusCode.AlreadyReported, Data = "You've applied before!" };
                    }
                    else
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
