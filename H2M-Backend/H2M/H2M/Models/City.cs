using System;
using System.Collections.Generic;

namespace H2M.Models
{
    public partial class City
    {
        public City()
        {
            User = new HashSet<User>();
        }

        public int Id { get; set; }
        public int CountryId { get; set; }
        public string Name { get; set; }
        public double? Longitude { get; set; }
        public double? Latitude { get; set; }
        public string Initals { get; set; }

        public ICollection<User> User { get; set; }
    }
}
