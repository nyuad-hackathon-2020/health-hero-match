using System;
using System.Collections.Generic;

namespace H2M.Models
{
    public partial class Nurse
    {
        public Nurse()
        {
            NurseSpeciality = new HashSet<NurseSpeciality>();
        }

        public int Id { get; set; }
        public string NurseId { get; set; }

        public User IdNavigation { get; set; }
        public ICollection<NurseSpeciality> NurseSpeciality { get; set; }
    }
}
