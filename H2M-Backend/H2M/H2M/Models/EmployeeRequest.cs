using System;
using System.Collections.Generic;

namespace H2M.Models
{
    public partial class EmployeeRequest
    {
        public int Id { get; set; }
        public int UserId { get; set; }
        public DateTime Time { get; set; }
        public int RequestId { get; set; }
        public int Status { get; set; }

        public HostpitalRequest Request { get; set; }
        public User User { get; set; }
    }
}
