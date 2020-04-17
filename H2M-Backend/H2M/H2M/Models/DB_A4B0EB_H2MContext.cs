using System;
using Microsoft.EntityFrameworkCore;
using Microsoft.EntityFrameworkCore.Metadata;

namespace H2M.Models
{
    public partial class H2MDbContext : DbContext
    {
        public H2MDbContext()
        {
        }

        public H2MDbContext(DbContextOptions<H2MDbContext> options)
            : base(options)
        {
        }

        public virtual DbSet<City> City { get; set; }
        public virtual DbSet<Country> Country { get; set; }
        public virtual DbSet<Doctor> Doctor { get; set; }
        public virtual DbSet<DoctorSpeciality> DoctorSpeciality { get; set; }
        public virtual DbSet<EmployeeRequest> EmployeeRequest { get; set; }
        public virtual DbSet<Hospital> Hospital { get; set; }
        public virtual DbSet<HostpitalRequest> HostpitalRequest { get; set; }
        public virtual DbSet<Nurse> Nurse { get; set; }
        public virtual DbSet<NurseSpeciality> NurseSpeciality { get; set; }
        public virtual DbSet<Role> Role { get; set; }
        public virtual DbSet<Speciality> Speciality { get; set; }
        public virtual DbSet<Tokens> Tokens { get; set; }
        public virtual DbSet<User> User { get; set; }

        protected override void OnConfiguring(DbContextOptionsBuilder optionsBuilder)
        {
            if (!optionsBuilder.IsConfigured)
            {
#warning To protect potentially sensitive information in your connection string, you should move it out of source code. See http://go.microsoft.com/fwlink/?LinkId=723263 for guidance on storing connection strings.
                optionsBuilder.UseSqlServer("Data Source=SQL5049.site4now.net;Initial Catalog=DB_A4B0EB_H2M;User Id=DB_A4B0EB_H2M_admin;Password=H2M12345;");
            }
        }

        protected override void OnModelCreating(ModelBuilder modelBuilder)
        {
            modelBuilder.Entity<City>(entity =>
            {
                entity.Property(e => e.Name)
                    .IsRequired()
                    .HasMaxLength(100);
            });

            modelBuilder.Entity<Country>(entity =>
            {
                entity.Property(e => e.Name)
                    .IsRequired()
                    .HasMaxLength(100);
            });

            modelBuilder.Entity<Doctor>(entity =>
            {
                entity.Property(e => e.Id).ValueGeneratedNever();

                entity.Property(e => e.DoctorId)
                    .IsRequired()
                    .HasMaxLength(50);

                entity.HasOne(d => d.IdNavigation)
                    .WithOne(p => p.Doctor)
                    .HasForeignKey<Doctor>(d => d.Id)
                    .OnDelete(DeleteBehavior.ClientSetNull)
                    .HasConstraintName("FK_Doctor_User");
            });

            modelBuilder.Entity<DoctorSpeciality>(entity =>
            {
                entity.HasKey(e => new { e.DoctorId, e.SpecialityId });

                entity.HasOne(d => d.Doctor)
                    .WithMany(p => p.DoctorSpeciality)
                    .HasForeignKey(d => d.DoctorId)
                    .OnDelete(DeleteBehavior.ClientSetNull)
                    .HasConstraintName("FK_DoctorSpeciality_Doctor");

                entity.HasOne(d => d.Speciality)
                    .WithMany(p => p.DoctorSpeciality)
                    .HasForeignKey(d => d.SpecialityId)
                    .OnDelete(DeleteBehavior.ClientSetNull)
                    .HasConstraintName("FK_DoctorSpeciality_Speciality");
            });

            modelBuilder.Entity<EmployeeRequest>(entity =>
            {
                entity.Property(e => e.Time).HasColumnType("datetime");

                entity.HasOne(d => d.Request)
                    .WithMany(p => p.EmployeeRequest)
                    .HasForeignKey(d => d.RequestId)
                    .OnDelete(DeleteBehavior.ClientSetNull)
                    .HasConstraintName("FK_EmployeeRequest_HostpitalRequest");

                entity.HasOne(d => d.User)
                    .WithMany(p => p.EmployeeRequest)
                    .HasForeignKey(d => d.UserId)
                    .OnDelete(DeleteBehavior.ClientSetNull)
                    .HasConstraintName("FK_EmployeeRequest_User");
            });

            modelBuilder.Entity<Hospital>(entity =>
            {
                entity.Property(e => e.Id).ValueGeneratedNever();

                entity.HasOne(d => d.IdNavigation)
                    .WithOne(p => p.Hospital)
                    .HasForeignKey<Hospital>(d => d.Id)
                    .OnDelete(DeleteBehavior.ClientSetNull)
                    .HasConstraintName("FK_Hospital_User");
            });

            modelBuilder.Entity<HostpitalRequest>(entity =>
            {
                entity.Property(e => e.Htmlpost)
                    .HasColumnName("HTMLPost")
                    .HasColumnType("text");

                entity.HasOne(d => d.Hospital)
                    .WithMany(p => p.HostpitalRequest)
                    .HasForeignKey(d => d.HospitalId)
                    .OnDelete(DeleteBehavior.ClientSetNull)
                    .HasConstraintName("FK_HostpitalRequest_Hospital");

                entity.HasOne(d => d.Speciality)
                    .WithMany(p => p.HostpitalRequest)
                    .HasForeignKey(d => d.SpecialityId)
                    .OnDelete(DeleteBehavior.ClientSetNull)
                    .HasConstraintName("FK_HostpitalRequest_Speciality");
            });

            modelBuilder.Entity<Nurse>(entity =>
            {
                entity.Property(e => e.Id).ValueGeneratedNever();

                entity.Property(e => e.NurseId)
                    .IsRequired()
                    .HasMaxLength(50);

                entity.HasOne(d => d.IdNavigation)
                    .WithOne(p => p.Nurse)
                    .HasForeignKey<Nurse>(d => d.Id)
                    .OnDelete(DeleteBehavior.ClientSetNull)
                    .HasConstraintName("FK_Nurse_User");
            });

            modelBuilder.Entity<NurseSpeciality>(entity =>
            {
                entity.HasKey(e => new { e.NurseId, e.SpecialityId });

                entity.HasOne(d => d.Nurse)
                    .WithMany(p => p.NurseSpeciality)
                    .HasForeignKey(d => d.NurseId)
                    .OnDelete(DeleteBehavior.ClientSetNull)
                    .HasConstraintName("FK_NurseSpeciality_Nurse");

                entity.HasOne(d => d.Speciality)
                    .WithMany(p => p.NurseSpeciality)
                    .HasForeignKey(d => d.SpecialityId)
                    .OnDelete(DeleteBehavior.ClientSetNull)
                    .HasConstraintName("FK_NurseSpeciality_Speciality");
            });

            modelBuilder.Entity<Role>(entity =>
            {
                entity.Property(e => e.Name)
                    .IsRequired()
                    .HasMaxLength(50);
            });

            modelBuilder.Entity<Speciality>(entity =>
            {
                entity.Property(e => e.Name)
                    .IsRequired()
                    .HasMaxLength(100);
            });

            modelBuilder.Entity<Tokens>(entity =>
            {
                entity.HasIndex(e => e.Token)
                    .HasName("IX_Tokens")
                    .IsUnique();

                entity.Property(e => e.CreationDate).HasColumnType("datetime");

                entity.Property(e => e.ExpiryDate).HasColumnType("datetime");

                entity.Property(e => e.Token)
                    .IsRequired()
                    .HasMaxLength(40);

                entity.HasOne(d => d.User)
                    .WithMany(p => p.Tokens)
                    .HasForeignKey(d => d.UserId)
                    .OnDelete(DeleteBehavior.ClientSetNull)
                    .HasConstraintName("FK_Tokens_User");
            });

            modelBuilder.Entity<User>(entity =>
            {
                entity.HasIndex(e => e.Email)
                    .HasName("IX_User")
                    .IsUnique();

                entity.Property(e => e.DateCreated).HasColumnType("datetime");

                entity.Property(e => e.Email)
                    .IsRequired()
                    .HasMaxLength(70);

                entity.Property(e => e.Gender)
                    .HasMaxLength(1)
                    .IsUnicode(false);

                entity.Property(e => e.Name).HasMaxLength(100);

                entity.Property(e => e.Password).IsRequired();

                entity.HasOne(d => d.City)
                    .WithMany(p => p.User)
                    .HasForeignKey(d => d.CityId)
                    .OnDelete(DeleteBehavior.ClientSetNull)
                    .HasConstraintName("FK_User_City");

                entity.HasOne(d => d.Country)
                    .WithMany(p => p.User)
                    .HasForeignKey(d => d.CountryId)
                    .OnDelete(DeleteBehavior.ClientSetNull)
                    .HasConstraintName("FK_User_Country");

                entity.HasOne(d => d.Role)
                    .WithMany(p => p.User)
                    .HasForeignKey(d => d.RoleId)
                    .OnDelete(DeleteBehavior.ClientSetNull)
                    .HasConstraintName("FK_User_Role");
            });
        }
    }
}
