using System;
using System.Collections.Generic;

namespace H2M.Models
{
    public partial class Country
    {
        public Country()
        {
            User = new HashSet<User>();
        }

        public int Id { get; set; }
        public string Name { get; set; }
        public double? Longitude { get; set; }
        public double? Latitude { get; set; }

        public ICollection<User> User { get; set; }
    }
}
