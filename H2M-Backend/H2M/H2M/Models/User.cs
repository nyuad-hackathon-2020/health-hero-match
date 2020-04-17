using System;
using System.Collections.Generic;

namespace H2M.Models
{
    public partial class User
    {
        public User()
        {
            Tokens = new HashSet<Tokens>();
        }

        public int Id { get; set; }
        public string Email { get; set; }
        public string Password { get; set; }
        public int RoleId { get; set; }
        public DateTime DateCreated { get; set; }
        public string Gender { get; set; }
        public int CountryId { get; set; }
        public int CityId { get; set; }
        public double? Longitude { get; set; }
        public double? Latitude { get; set; }
        public string Name { get; set; }

        public City City { get; set; }
        public Country Country { get; set; }
        public Role Role { get; set; }
        public Doctor Doctor { get; set; }
        public Hospital Hospital { get; set; }
        public Nurse Nurse { get; set; }
        public ICollection<Tokens> Tokens { get; set; }
    }
}
