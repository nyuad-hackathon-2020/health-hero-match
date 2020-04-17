using System;
using System.Collections.Generic;

namespace H2M.Models
{
    public partial class Hospital
    {
        public Hospital()
        {
            HostpitalRequest = new HashSet<HostpitalRequest>();
        }

        public int Id { get; set; }
        public double? Longitude { get; set; }
        public double? Latitude { get; set; }

        public User IdNavigation { get; set; }
        public ICollection<HostpitalRequest> HostpitalRequest { get; set; }
    }
}
