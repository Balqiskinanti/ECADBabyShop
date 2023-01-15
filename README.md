# ECADBabyShop : ECADAssignment1-P01-Team1

* [ECADBabyShop : ECADAssignment1-P01-Team1](https://github.com/balqiskinanti/ecadbabyshop#ECADBabyShop-ECADAssignment1-P01-Team1)
* [Local Development](https://github.com/balqiskinanti/ecadbabyshop#Local-Development)
  * [Prerequisites](https://github.com/balqiskinanti/ecadbabyshop#Prerequisites)
  * [Database Setup](https://github.com/balqiskinanti/ecadbabyshop#Database-Setup)
  * [Clone the Repository](https://github.com/balqiskinanti/ecadbabyshop#Clone-the-Repository)
  * [Open VSCode and Start Coding](https://github.com/balqiskinanti/ecadbabyshop#Open-VSCode-and-Start-Coding)
  * [Run Project](https://github.com/balqiskinanti/ecadbabyshop#Run-Project)
* [Wireframe & Design](https://github.com/balqiskinanti/ecadbabyshop#Wireframe-&-Design)
* [Developer Notes](https://github.com/balqiskinanti/ecadbabyshop#Developer-Notes)
  * [Best Practices](https://github.com/balqiskinanti/ecadbabyshop#Best-Practices)
  * [Template Code](https://github.com/balqiskinanti/ecadbabyshop#Template-Code)
  * [Showing Logo on Top of Browser](https://github.com/balqiskinanti/ecadbabyshop#Showing-Logo-on-Top-of-Browser)
* [Common Errors](https://github.com/balqiskinanti/ecadbabyshop#Common-Errors)
  * [SMTP Error](https://github.com/balqiskinanti/ecadbabyshop#SMTP-Error)
  * [CSS Not Updating](https://github.com/balqiskinanti/ecadbabyshop#CSS-Not-Updating)

## Local Development

Clone and run this app in your machine with the following steps:

### Prerequisites

You need `XAMPP` installed in your machine. 

### Database Setup
1. Open MySQL Admin 
2. Go to "Databases" on top bar
3. Enter "ecad_assgdb" as the database name and click "Create" button
4. Click on the new database created on the left panel
5. Click "Import" on top bar
6. Choose file "ECAD Assignment 1 2022Oct - DB Setup Script". Click "Import"

### Clone the Repository

Use `git clone` command to clone project to the current directory using HTTPS. Execute this in the terminal(command line):

```console
cd ..
cd ..
cd xampp
cd htdocs
git clone https://github.com/Balqiskinanti/ECADBabyShop.git

```

### Open VSCode and Start Coding

Make sure you are in the root directory of the project. You can use `cd` command for Windows.

```console
cd ECADBabyShop
code .

``` 

### Run Project

This runs the app in development mode.\
Start Apache server and MySQL database, open [http://localhost:8081/ECADBabyShop](http://localhost:8081/ECADBabyShop) to view it in your browser.

## Wireframe & Design
![logo](https://github.com/balqiskinanti/ecadbabyshop/blob/main/Images/Template/LongLogo.PNG)
- [Figma Design File](https://www.figma.com/file/AZaBWXHvkOgs32SwgKyDDK/EBS?node-id=234%3A275&t=cNmXYBcS1z5PlMh0-1)
- [Logo Reference Link](https://looka.com/explore)
- [Baby Image Reference Link](https://www.transparentpng.com/details/baby-girl-pictures_657.html)

## Developer Notes
### Best Practices
- Variable names: $myName
- Function names: get_name(), use verb
- File names: orderDetails.php
- Close $stmt, $conn as soon as possible

### Template Code
```php
<?php 
// header
include("./Pages/Shared/header.php"); 
?>

<?php
// render main body
include("../path/to/your/file.php");
?>

<?php 
// footer
include("./Pages/Shared/footer.php"); 
?>

``` 

### Showing Logo on Top of Browser
1. Go to C:\xampp\htdocs
2. Delete the default favicon.ico file
3. Copy and paste ShortLogo.PNG to the directory

## Common Errors

### SMTP Error 
1. Click on the circle avatar. Navigate to “Manage Google Account”
2. Search and click on “2 Step Verification”
3. Set up 2-FA
4. Search and click on “App Passwords”
5. Select “Mail” and “Windows Computer”. Click “Generate” button
6. Copy the app password in the orange container
![image](https://user-images.githubusercontent.com/72959939/212126598-baf7df72-efe8-4b06-9885-d9d052c43ebb.png)
7. Instead of the normal password, change the PHP code to the generated app password
![image](https://user-images.githubusercontent.com/72959939/212126654-e46b8e91-cf04-4e73-8e0e-0aa168b46a7b.png)


### CSS Not Updating
1. Go to settings
2. Clear cache
3. Reload browser
