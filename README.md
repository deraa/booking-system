# Fleet Management Task


Challenge brief
---

- implement a building a fleet-management system (bus-booking
system with MYSQL and Laravel FrameWork
---

### What had I do
- i implemented 2 APIs for check available seat and for list all seats available

---

### How to Run The Code

- Download the code repo.
- please self host the code at any apache server (version 2.4)
- run command `php artisan serve` to make server up
- run command `php artisan migrate` to build database
- run command `php artisan db:seed` to set dump data
- hit the url `***/api/check-available-seat?start=AlFayyum&end=Asyut` to get first Api response to check if there are any seat
- hit the url `***/api/list-free-seats?start=AlFayyum&end=Asyut` to get first Api response to check if there are any seat



---

### Trade-offs

- i have very big challenge to set the right architect to database
- I always used to have unit test for using **PHPUNIT** but I do not have the time to do so at the challenge. 
