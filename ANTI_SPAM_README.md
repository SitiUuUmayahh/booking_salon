# 🔒 Fitur Anti-Spam Booking

Sistem ini telah dilengkapi dengan 3 mekanisme anti-spam untuk mencegah booking palsu/spam:

## 1. ✅ Batasan Booking Aktif (Max 5)

**Cara Kerja:**
- User hanya bisa memiliki maksimal **5 booking aktif** (status: pending/confirmed) secara bersamaan
- Jika sudah 5, user harus menyelesaikan atau membatalkan booking lama terlebih dahulu
- Mencegah user membuat booking berlebihan

**Kode:** `BookingController.php` line 42-51

## 2. ⏰ Cooldown Period (30 Menit)

**Cara Kerja:**
- Setelah membuat booking, user harus **menunggu 30 menit** sebelum bisa booking lagi
- Mencegah spam booking dalam waktu singkat
- Waktu booking terakhir disimpan di kolom `last_booking_at`

**Kode:** `BookingController.php` line 35-41

## 3. 📊 Track Cancel Rate & Auto-Suspend

**Cara Kerja:**
- Sistem mencatat berapa kali user membatalkan booking (`cancel_count`)
- **Warning:** Jika cancel 3-4x → User dapat peringatan
- **Suspended:** Jika cancel ≥5x → Akun otomatis di-suspend
- User yang suspended tidak bisa booking sampai admin mengaktifkan kembali

**Kode:** `BookingController.php` line 156-178

## 🎨 User Reputation Badge

Setiap user memiliki badge reputasi yang terlihat di halaman admin:

| Badge | Kondisi | Warna |
|-------|---------|-------|
| ✓ Baik | Cancel count = 0 | Hijau |
| ⚡ 1-2x Cancel | Cancel count 1-2 | Kuning |
| ⚠️ Warning | Cancel count 3-4 | Orange |
| ⛔ Suspended | Cancel count ≥5 | Merah |

## 🛠️ Fitur Admin

Admin dapat:
1. ✅ **Melihat reputation badge** user di detail booking
2. 🔓 **Unsuspend user** yang di-suspend
3. 🔄 **Reset cancel count** user untuk memberi kesempatan kedua
4. 📊 Melihat statistik: Total booking, Cancel count, dll

**Route:**
- POST `/admin/users/{id}/unsuspend` - Aktifkan kembali user
- POST `/admin/users/{id}/reset-cancel-count` - Reset cancel count

## 📋 Database Changes

Migration `2026_01_17_090037_add_spam_tracking_to_users_table.php`:

```sql
- cancel_count: int (default 0)
- last_booking_at: timestamp (nullable)
- is_suspended: boolean (default false)
- suspend_reason: text (nullable)
```

## 🧪 Testing

**Test Cooldown:**
1. Buat booking sebagai user biasa
2. Coba buat booking lagi langsung → Error: "Mohon tunggu X menit"

**Test Cancel Tracking:**
1. Buat 5 booking
2. Cancel semua satu per satu
3. Booking ke-3 & ke-4 → Warning muncul
4. Booking ke-5 → Auto-suspend

**Test Admin Features:**
1. Login sebagai admin
2. Buka detail booking dari user yang suspended
3. Klik "Aktifkan Kembali User"
4. User bisa booking lagi

## 📈 Future Enhancements

Fitur yang bisa ditambahkan nanti:
- [ ] Email notification saat user di-suspend
- [ ] Dashboard analytics untuk track spam users
- [ ] Rate limiting berbasis IP address
- [ ] Payment gateway untuk booking (down payment)
- [ ] Verifikasi email/phone number
- [ ] CAPTCHA di form booking
