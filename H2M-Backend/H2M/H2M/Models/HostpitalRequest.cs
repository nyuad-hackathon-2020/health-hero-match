using System;
using System.Collections.Generic;

namespace H2M.Models
{
    public partial class HostpitalRequest
    {
        public HostpitalRequest()
        {
            EmployeeRequest = new HashSet<EmployeeRequest>();
        }

        public int Id { get; set; }
        public int HospitalId { get; set; }
        public int Count { get; set; }
        public bool Enabled { get; set; }
        public string Htmlpost { get; set; }
        public int SpecialityId { get; set; }

        public Hospital Hospital { get; set; }
        public Speciality Speciality { get; set; }
        public ICollection<EmployeeRequest> EmployeeRequest { get; set; }
    }
}
