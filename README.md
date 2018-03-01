Oren's Website / Content Management System
==========================================

This project serves partially as a backup for the php templates and static html of my personal website.
However it also includes some python programs I use as a CMS. If any of this setup is beneficial to you,
feel free to use it. This README will serve as documentation for how to implement it in your system and
write your own templates.

This repository is only part of a website. Any final production system it is installed on requires the
LAMP stack, a running MySQL server (I use MariaDB), and the rsc folder to hold all your images and such.
This setup assumes a structure of multiple pages (think articles, blog posts, etc), that are sorted into 
different categories, each of which is rendered by a different template. This way, your DIY how-to looks 
different from your movie review. However, they both share common elements, for example:

  * Title
  * Subtitle
  * Publication date
  * Description
  * Thumbnail file
  * Body html
  * Sidebar html
  * Template to render with

Each page is stored as a row in an SQL table using the above elements as values. The table format above
isn't strictly required. You can add your own columns, and not every page needs to fill every column. In
my website's SQL table, I mark the title, publication date, description, thumbnail, and template mandatory
so they render correctly in the home page feed and in previews when shared on social media.

On the production server, the repository is meant to be placed in Apache's root directory, /var/www/html.
Each article has a unique integer identifier. To fetch that article, you take the base64 encoding of the
ID and pass that as a query to the home page. It's important to pad the ID with a multiple of 3 character
(eg 003, 000003, etc), so base64 doesn't make a string with the '=' character. After given the base64
encoded ID, the homepage will redirect you to the appropriate template and when the template is passed
that same ID, it'll look up the corresponding row in the SQL table and populate itself using the values
in that row. The production server also has a python service that handles the publishing of new articles.
If you'd rather push changes manually, power to you.

On your development machine, this repository is placed wherever is convenient for your IDE to use as a web
root. Your development machine must also have a MySQL instance running, where a database called 'website' by 
default creates a table called pages. On the development workstation, this table typically only contains a 
few recent pages you're currently developing. The body of the page is static html that must be coded from 
scratch, so this local SQL database allows you to preview the text when it's put into the desired template. 
After you're pleased with the result, you can publish the pages to your production server. This will take 
the contents of your local SQL pages table and join them with the complete table on the production server. 
You can then delete your local changes, if you wish.
