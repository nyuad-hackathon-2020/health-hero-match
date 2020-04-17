using System;
using System.Collections.Generic;

namespace H2M.Models
{
    public partial class Tokens
    {
        public int Id { get; set; }
        public string Token { get; set; }
        public int UserId { get; set; }
        public int RoleId { get; set; }
        public DateTime CreationDate { get; set; }
        public DateTime ExpiryDate { get; set; }

        public User User { get; set; }
    }
}
