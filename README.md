Oren's Website
==========================================

This project serves partially as a backup for the php templates and static html of my personal website.
If any of this setup is beneficial to you, feel free to use it. This README will serve as documentation
for how to implement it in your system and write your own templates. On a production server, this repository
should be placed in Apache's root directory, typically /var/www/html. On your development machine, place
it wherever is convenient for your IDE.

This repository is only part of a website. Any final production system it is installed on requires the
LAMP stack, a running MySQL server (I use MariaDB), and the rsc folder to hold all your images. This setup
assumes a structure of multiple pages (think articles, blog posts, etc), that are sorted into different
categories, each of which is rendered by a different template. This way, your DIY how-to looks different
from your movie review. However, they both share common elements, for example:

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

Each article has a unique integer identifier. To fetch that article, you take the base64 encoding of it's
ID in the SQL table and pass that as a query to the home page. It's important to pad the ID with a multiple
of 3 characters (eg 003, 000003, etc), so base64 doesn't make a string with the '=' character, as that'll
mess up how the URL is parsed. After given the base64 encoded ID, the homepage will redirect you to the
appropriate template and when the template is passed that same ID, it'll look up the corresponding row in
the SQL table and populate itself using the values in that row.

I also suggest using [mywebsql](http://mywebsql.net/) tool. It's useful as a rudimentary content management
system

Commands to run

1. "mysql -u root --where="CLAUSE HERE" pages > import.sql"
2. copy import.sql to the development server
3. Make edits to import.sql if needed
4. On server "mysql -u root website < import.sql".

TODO: Make a python script to automate the syncing of new data