using System;
using System.Collections.Generic;

namespace H2M.Models
{
    public partial class DoctorSpeciality
    {
        public int DoctorId { get; set; }
        public int SpecialityId { get; set; }

        public Doctor Doctor { get; set; }
        public Speciality Speciality { get; set; }
    }
}
