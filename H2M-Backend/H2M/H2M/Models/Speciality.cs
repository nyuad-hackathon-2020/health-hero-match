using System;
using System.Collections.Generic;

namespace H2M.Models
{
    public partial class Speciality
    {
        public Speciality()
        {
            DoctorSpeciality = new HashSet<DoctorSpeciality>();
            HostpitalRequest = new HashSet<HostpitalRequest>();
            NurseSpeciality = new HashSet<NurseSpeciality>();
        }

        public int Id { get; set; }
        public string Name { get; set; }
        public int? Type { get; set; }

        public ICollection<DoctorSpeciality> DoctorSpeciality { get; set; }
        public ICollection<HostpitalRequest> HostpitalRequest { get; set; }
        public ICollection<NurseSpeciality> NurseSpeciality { get; set; }
    }
}
