using System;
using System.Collections.Generic;

namespace H2M.Models
{
    public partial class Doctor
    {
        public Doctor()
        {
            DoctorSpeciality = new HashSet<DoctorSpeciality>();
        }

        public int Id { get; set; }
        public string DoctorId { get; set; }

        public User IdNavigation { get; set; }
        public ICollection<DoctorSpeciality> DoctorSpeciality { get; set; }
    }
}
