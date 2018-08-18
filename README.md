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
  * Published

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

Commands to run

1. CREATE VIEW publish AS SELECT * FROM pages WHERE \[CONDITION HERE\];
2. Copy publish to production server
3. UPDATE website.pages w RIGHT JOIN website.publish p ON (w.id = p.id);

TODO: Make a python script to automate the syncing of new data

The published flag indicates which posts should show on the public website. 0 means unpublished, 1 means published. The
feeds on the site will check if the file public-facing.lock exists, and if it does, the feeds will not display
unpublished articles. The staging site has no such lock file, and so unpublished articles can be viewed there while
still in their drafting stage.