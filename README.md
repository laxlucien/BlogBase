# BlogBase
Implimentation of BlogBase for CS 360 project

Description: Design a Blog database, more like a eNewspaper, in which there are five kinds of users – editors, 
graphic designers, writers or contributors, users or readers, and advertisers. In BlogBase, authors will be able 
to  write  and  contribute  articles  using  a  WYSWYG  HTML  editor  such  as  CK  Editor  or  HTMLG.  In  their 
articles, the authors will be able to include pics or videos, and references/links to other HTML pages. All five 
types  of  users  will  have  defined  roles.  Readers  will  be  able  to  comment  on  a  public  article,  and  other 
users/readers should be able to respond to the comments in a Facebook style commenting scheme. Visibility 
should be decided based on a scheme similar to Facebook.
However, editors should be able to control the publication of each of the submitted articles by the authors. 
Articles will be presented to a reader/user clustered by date in a newspaper style. Editors through the graphic 
designers  should  be  able  to  restyle  the  articles  before  publishing  that  will  be  available  in  a  queue.  Once 
published, authors are not allowed to edit or delete the published articles. The two copies will be distinct – the 
submitted copy will be owned by the authors, but the published copy owned by the editor.
All articles should have an expiration and migrate to the archive, but remain accessible by all. An index and 
search bar should be supported to find articles of interest. Various search can be supported – authors name, 
date,  articles’  title  keywords,  or  content  keywords.  It  should  also  support  search  by  user  names  who 
commented on an article.
Your system must have the following features, and all the source code should be hosted on GitHub with 
proper documentation and shared with the instructor:

1. A user login system with password to control access to the system. A user can have multiple roles – 
editor, graphic designer, author, reader, and advertisers. They can perform the tasks allowed by their 
assigned roles. The system admin approves each user’s registration. That means, when a user opens 
an account, it is a request that sits in a queue until it is approved. 

2. A web-based HTML authoring and submission system as described above – texts, pics and videos. 
Editors will be able to move submitted articles under their control by making a copy. Hosted on a web 
server at https://blogbase.smartdblab.org. 

3. An  editing  dashboard  in  which  graphic  designers  will  be  able  to  design  the  presentation  of  a  daily 
newspaper. 

4. A reader dashboard from which readers will be able to find a paper edition of their choice, or a specific 
article  as  described  above.  They  will  also  be  able  to  comment  on  any  of  the  article  or  respond  to 
comments as outlined above. 

5. An advertiser dashboard using which advertisers will be able to submit a picture as an ad of various 
pre-determined sizes to be included in the newspaper of a generic or specific date. The price paid will 
be based on the location and position of the newspaper. 

The database configuration file for the database is called: config.inc.php
The exported database file is called: blog_base.sql
