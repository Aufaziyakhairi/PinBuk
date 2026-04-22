# Sistem Peminjaman Buku - Testing & Verification Guide

## ✅ Application Status

### Completed & Verified
- **Framework**: Laravel 13 with Breeze authentication
- **Database**: MySQL with 4 tables (users, books, borrowings, fines)
- **Routes**: All 7+ routes responding correctly (200 OK or 302 redirect)
- **Tests**: All 25 built-in tests PASSING
- **Server**: Running on http://localhost:8000 without errors
- **Models**: All 4 models with relationships and business logic
- **Views**: All 13 Blade templates compiled without syntax errors
- **Database**: Seeded with 6 users (1 admin + 5 users) and 5 books

### Role-Based Features
**Admin** (email: admin@perpustakaan.test)
- ✅ Create/Read/Update/Delete books
- ✅ View all borrowings
- ✅ View all fines and mark as paid
- ✅ Monthly fine report
- ✅ Dashboard with statistics

**User**
- ✅ View available books
- ✅ Borrow books (auto-decreases available_quantity)
- ✅ Return books (auto-creates fine if overdue)
- ✅ View personal borrowing history
- ✅ View personal fines
- ✅ Personal dashboard

## 🧪 How to Test

### 1. **Access the Application**
```
URL: http://localhost:8000
```

### 2. **Login Credentials**

**Admin Account** (Test Admin Features)
- Email: `admin@perpustakaan.test`
- Password: `password`

**User Accounts** (Test User Features) - All use password: `password`
- user1@example.com
- user2@example.com  
- user3@example.com
- user4@example.com
- user5@example.com

### 3. **Test Workflows**

#### Workflow A: Admin Book Management
1. Login as admin
2. Go to "Manajemen Buku" (Book Management)
3. Create a new book (title, author, quantity, status)
4. Edit the book details
5. View book details and borrowing history
6. ✓ Verify book appears in user's borrowing list

#### Workflow B: User Borrowing Books
1. Login as user1
2. Go to "Pinjam Buku" (Borrow Book) section
3. Select an available book and set due date
4. ✓ Verify book borrowed successfully
5. ✓ Check available_quantity decreased by 1
6. Go to Dashboard
7. ✓ Verify book appears in "Peminjaman Aktif" (Active Loans)

#### Workflow C: Returning Book & Fine Calculation
1. As user1, go to Peminjaman (Borrowings)
2. Return book with return date
3. If return date > due date:
   - ✓ Fine should be created automatically
   - ✓ Amount = (days_late × Rp 5,000)
4. Go to "Denda" (Fines)
5. ✓ Verify fine appears with correct amount

#### Workflow D: Admin Fine Management
1. Login as admin
2. Go to "Denda" (Fines)
3. ✓ View all users' fines
4. Mark fine as paid
5. ✓ Status changes to "paid"
6. Go to "Laporan Denda" (Fine Report)
7. ✓ View monthly fine statistics

### 4. **Business Logic to Verify**

- [ ] Book quantity decreases when borrowed
- [ ] Available quantity increases when book is returned
- [ ] Fine is created ONLY if return date > due date
- [ ] Fine amount = days_late × Rp 5,000
- [ ] Users cannot see other users' fines (403 Forbidden)
- [ ] Admin can see all fines
- [ ] Dashboard shows correct statistics
- [ ] Search/filter works on books list

### 5. **Edge Cases to Test**

- [ ] Borrowing same book multiple times
- [ ] Returning book before due date (no fine)
- [ ] Multiple users borrowing same book (available_quantity--)
- [ ] Creating book with quantity = 1, 2 users borrow it
- [ ] Soft-deleted books (won't appear in available list)
- [ ] Fine payment status persists after marking as paid

## 📝 Checklist for Testing

### Navigation & UI
- [ ] Navigation menu shows different links for admin vs user
- [ ] Role-based menu items display correctly
- [ ] All links work without 404 errors
- [ ] Forms validate input correctly

### Database Integrity  
- [ ] Book quantity and available_quantity sync correctly
- [ ] Borrowing records link to correct user and book
- [ ] Fine records link to correct borrowing and user
- [ ] Timestamps (created_at, updated_at) work correctly

### Authorization
- [ ] User cannot access /books (admin only)
- [ ] User cannot edit books
- [ ] User cannot view other users' fines
- [ ] Admin can view all resources
- [ ] Unauthenticated users redirected to login

## 🐛 Bug Reporting Format

If you find an issue, note:
1. **Route**: /which-page
2. **User Role**: admin or user
3. **Action**: What you clicked/submitted
4. **Expected**: What should happen
5. **Actual**: What happened instead
6. **Error Message**: Any error text shown

Example:
- **Route**: /borrowings/1/edit
- **User Role**: user
- **Action**: Clicked "Kembalikan Buku" (Return Book) button
- **Expected**: Returns book and possibly creates fine
- **Actual**: Shows 404 error
- **Error**: "Route not found"

## ✨ Next Steps

1. **Test the workflows** above systematically
2. **Report any bugs** using the format above
3. Agent will **fix bugs one by one**
4. **Re-test** after each fix to ensure it works
5. Continue until all features work correctly

## 📊 Application Statistics

- **Total Routes**: 7 main route groups
- **Total Views**: 13 Blade templates
- **Models**: 4 (User, Book, Borrowing, Fine)
- **Controllers**: 4 (BookController, BorrowingController, FineController, DashboardController)
- **Migrations**: 4 table creation migrations
- **Tests**: 25 passing tests
- **Test Factories**: 4 models with factories for testing

---

**Status**: ✅ Ready for Testing
**Last Updated**: 2026-04-08
**Server**: Running without errors
