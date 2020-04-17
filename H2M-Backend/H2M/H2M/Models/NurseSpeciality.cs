using System;
using System.Collections.Generic;

namespace H2M.Models
{
    public partial class NurseSpeciality
    {
        public int NurseId { get; set; }
        public int SpecialityId { get; set; }

        public Nurse Nurse { get; set; }
        public Speciality Speciality { get; set; }
    }
}
