<html>
    <head>

        <!-- Metadata -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta charset="utf-8">
        <meta name="description" content="Holy Ghost Prep Announcement Page">
        <link rel="shortcut icon" href="favicon.ico">


        <title>EHGP Announcements</title>

        <!-- JQuery and AJAX -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js" charset="utf-8"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <!-- Our Custom JS -->
        <script src="textSearcher.js" charset="utf-8"></script>
        <script src="main_functions.js" charset="utf-8"></script>
        <!-- Bootstrap CSS CDN -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

        <!-- JS to set body HEX color as a cookie -->
        <script>
            function rgb2hex(rgb){
             rgb = rgb.match(/^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i);
             return (rgb && rgb.length === 4) ? "#" +
              ("0" + parseInt(rgb[1],10).toString(16)).slice(-2) +
              ("0" + parseInt(rgb[2],10).toString(16)).slice(-2) +
              ("0" + parseInt(rgb[3],10).toString(16)).slice(-2) : '';
            }

            $(document).ready(function(){
                let color = $("body").css("background-color");
                document.getElementById("settings-bg-color").value = rgb2hex(color);
                var domain = window.location.host.split(/\.(.+)/)[1];
                document.cookie = "css=" + rgb2hex(color) + "; path=/; domain=" + domain;
            });
        </script>
        <link rel="stylesheet" href="themes/main.css">
		<link rel="stylesheet" href="themes/style.css" type="text/css">
    </head>
    <body>
        <!-- Navbar -->
        <div class="sticky-top">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <ul class="navbar-nav mx-auto">
                        <div class="navbar-nav">
                            <!-- Search box -->
                            <li class="nav-item search-box">
                                <form class="form-inline searchForm" action="textSearcher.php" method="POST">
                                    <input type="search" name="searchTerm" id="searchbar" class="search center form-control" placeholder="Search by term..." autocomplete="off" required>
                                </form>
                            </li>
                            <!-- Select date to view announcements -->
                            <li class="nav-item">
                                <div class="form-group">
                                    <form class='form-inline' method='GET' action='announcements.php'><select class='form-control' name='date' onchange='this.form.submit()'><option value=''>Select Date</option><option value=2020-05-21>2020-05-21</option><option value=2020-05-20>2020-05-20</option><option value=2020-05-19>2020-05-19</option><option value=2020-05-18>2020-05-18</option><option value=2020-05-17>2020-05-17</option><option value=2020-05-16>2020-05-16</option><option value=2020-05-15>2020-05-15</option><option value=2020-05-14>2020-05-14</option><option value=2020-05-13>2020-05-13</option><option value=2020-05-12>2020-05-12</option><option value=2020-05-11>2020-05-11</option><option value=2020-04-28>2020-04-28</option><option value=2020-04-27>2020-04-27</option><option value=2020-04-26>2020-04-26</option><option value=2020-04-25>2020-04-25</option><option value=2020-04-24>2020-04-24</option><option value=2020-04-23>2020-04-23</option><option value=2020-04-08>2020-04-08</option><option value=2020-04-07>2020-04-07</option><option value=2020-04-06>2020-04-06</option><option value=2020-04-05>2020-04-05</option><option value=2020-04-04>2020-04-04</option><option value=2020-04-03>2020-04-03</option><option value=2020-04-02>2020-04-02</option><option value=2020-04-01>2020-04-01</option><option value=2020-03-31>2020-03-31</option><option value=2020-03-30>2020-03-30</option><option value=2020-01-28>2020-01-28</option><option value=2020-01-27>2020-01-27</option><option value=2020-01-26>2020-01-26</option><option value=2020-01-25>2020-01-25</option><option value=2020-01-24>2020-01-24</option><option value=2020-01-23>2020-01-23</option><option value=2020-01-22>2020-01-22</option><option value=2019-12-19>2019-12-19</option><option value=2019-12-18>2019-12-18</option><option value=2019-12-17>2019-12-17</option><option value=2019-12-16>2019-12-16</option><option value=2019-12-15>2019-12-15</option><option value=2019-12-14>2019-12-14</option><option value=2019-12-13>2019-12-13</option><option value=2019-12-02>2019-12-02</option><option value=2019-12-01>2019-12-01</option><option value=2019-11-30>2019-11-30</option><option value=2019-11-29>2019-11-29</option><option value=2019-11-28>2019-11-28</option><option value=2019-11-27>2019-11-27</option><option value=2019-11-26>2019-11-26</option><option value=2019-11-25>2019-11-25</option><option value=2019-11-24>2019-11-24</option><option value=2019-11-23>2019-11-23</option><option value=2019-11-22>2019-11-22</option><option value=2019-11-21>2019-11-21</option><option value=2019-11-13>2019-11-13</option><option value=2019-11-12>2019-11-12</option><option value=2019-11-11>2019-11-11</option><option value=2019-11-10>2019-11-10</option><option value=2019-11-09>2019-11-09</option><option value=2019-11-08>2019-11-08</option><option value=2019-11-07>2019-11-07</option><option value=2019-11-06>2019-11-06</option><option value=2019-11-05>2019-11-05</option><option value=2019-11-04>2019-11-04</option><option value=2019-11-03>2019-11-03</option><option value=2019-11-02>2019-11-02</option><option value=2019-11-01>2019-11-01</option><option value=2019-10-24>2019-10-24</option><option value=2019-10-23>2019-10-23</option><option value=2019-10-22>2019-10-22</option><option value=2019-10-21>2019-10-21</option><option value=2019-10-18>2019-10-18</option><option value=2019-10-17>2019-10-17</option><option value=2019-10-16>2019-10-16</option><option value=2019-10-15>2019-10-15</option><option value=2019-10-14>2019-10-14</option><option value=2019-10-13>2019-10-13</option><option value=2019-10-12>2019-10-12</option><option value=2019-10-11>2019-10-11</option><option value=2019-10-10 selected=selected>2019-10-10</option><option value=2019-10-09>2019-10-09</option><option value=2019-10-08>2019-10-08</option><option value=2019-10-07>2019-10-07</option><option value=2019-10-06>2019-10-06</option><option value=2019-10-05>2019-10-05</option><option value=2019-10-04>2019-10-04</option><option value=2019-10-03>2019-10-03</option><option value=2019-10-02>2019-10-02</option><option value=2019-10-01>2019-10-01</option><option value=2019-09-30>2019-09-30</option><option value=2019-09-29>2019-09-29</option><option value=2019-09-28>2019-09-28</option><option value=2019-09-27>2019-09-27</option><option value=2019-09-26>2019-09-26</option><option value=2019-09-25>2019-09-25</option><option value=2019-09-24>2019-09-24</option><option value=2019-09-23>2019-09-23</option><option value=2019-09-22>2019-09-22</option><option value=2019-09-21>2019-09-21</option><option value=2019-09-20>2019-09-20</option><option value=2019-09-19>2019-09-19</option><option value=2019-09-18>2019-09-18</option><option value=2019-09-17>2019-09-17</option><option value=2019-09-16>2019-09-16</option><option value=2019-09-15>2019-09-15</option><option value=2019-09-14>2019-09-14</option><option value=2019-09-13>2019-09-13</option><option value=2019-09-12>2019-09-12</option><option value=2019-09-11>2019-09-11</option><option value=2019-09-10>2019-09-10</option><option value=2019-09-09>2019-09-09</option><option value=2019-09-08>2019-09-08</option><option value=2019-09-07>2019-09-07</option><option value=2019-09-06>2019-09-06</option><option value=2019-09-05>2019-09-05</option><option value=2019-09-04>2019-09-04</option><option value=2019-09-03>2019-09-03</option><option value=2019-09-02>2019-09-02</option><option value=2019-09-01>2019-09-01</option><option value=2019-08-31>2019-08-31</option><option value=2019-08-30>2019-08-30</option><option value=2019-08-29>2019-08-29</option><option value=2019-08-28>2019-08-28</option><option value=2019-08-27>2019-08-27</option><option value=2019-08-26>2019-08-26</option></select>                                </div>
                            </li>
                            <!-- Select grade to filter by -->
                            <li class="nav-item">
                                <div class="form-group">
                                    <select class='form-control' name='view' onchange='this.form.submit()'><option value='0'>All Grades</option><option value='1'>Freshman</option><option value='2'>Sophomore</option><option value='3'>Junior</option><option value='4'>Senior</option><option value='5'>Freshman-Sophomore</option><option value='6'>Junior-Senior</option></select></form>                                </div>
                            </li>
                        </div>
                    </ul>
                </div>
            </nav>
            <div class="scroll-line"></div>
        </div>
        <!-- HGP Logo Header -->
        <div class="mx-auto" style="width: 100%; ">
            <div class="header-top">
                <img src="logo.png" alt="HGP Logo" class="img-logo">
            </div>
            <br>
        </div>
        <!-- This is where the announcements page starts -->
            <div class="mx-auto" id="canv-container" style="width: 90%;">
            <div class="alert-header"></div>
            <h3 class='center'>Thursday, 2019-10-10</h3><br><div class='text-center'><form action='http://ehgp.holyghostprep.org' style='display:inline-block'><input style='display:inline-block' type='submit' class='btn btn-primary announcements-btns' value='Home'></form><button style='display:inline-block' type='button' class='btn btn-primary announcements-btns' data-toggle='modal' data-target='#settingsModal'>Settings</button>
                </div>                <div class='card-container'>
                  <div class='card'><h5 class='card-header'>From: Mr. Conlin<img src='drag.png' alt='drag' class='drag float-right'></h5><div class='card-body'><h5 class='card-title'>To: All Grades</h5><p class='card-text'> If you pre-registered online for our CARES Walk but were not able to come to the walk, please stop by my office for your CARES Walk t-shirt. <br />
<br />
Anyone who would like to purchase this year's CARES Walk t-shirt, please bring $15 to my office. </p></div>                  </div>
                  <div class='card'><h5 class='card-header'>From: Mr. Conlin<img src='drag.png' alt='drag' class='drag float-right'></h5><div class='card-body'><h5 class='card-title'>To: All Grades</h5><p class='card-text'> Please excuse the Varsity and JV soccer teams at 2:15 today for away games.<br />
<br />
Varsity and JV soccer players are reminded to see their last period teacher before the end of break today.</p></div>                  </div>
                  <div class='card'><h5 class='card-header'>From: Mr. Whartenby<img src='drag.png' alt='drag' class='drag float-right'></h5><div class='card-body'><h5 class='card-title'>To: All Grades</h5><p class='card-text'> Slay Sarcoma 5k Run / Walk <br />
<br />
This event is a great way to complete service hours while also coming together as a Ghost Community to support each other as the event is hosted by a current member of our community. This fundraiser benefits Sarcoma Research Activities and the Abramson Cancer Center at the University of Pennsylvania. <br />
<br />
When: Oct 12, 2019 @8:30AM<br />
<br />
Where: Core Creek Park, Pavilion 11<br />
<br />
250 Tollgate Road Langhorne, PA 19047<br />
<br />
Register Here <br><a href='https://forms.gle/SBXNStBeRwAUY1Fu6' class='btn btn-primary but' target='_blank'>forms.gle</a></p></div>                  </div>
                  <div class='card'><h5 class='card-header'>From: Ms.Ciaramella<img src='drag.png' alt='drag' class='drag float-right'></h5><div class='card-body'><h5 class='card-title'>To: All Grades</h5><p class='card-text'> Do you like building and painting? Lights and sound? How about the excitement of being backstage for a live show? Then the Clue Crew is for YOU!<br />
<br />
This is the last call for Stage Crew sign-ups. Let Ms. C. know if you're interested no later than Friday.</p></div>                  </div>
                  <div class='card'><h5 class='card-header'>From: Mr. Gabriele<img src='drag.png' alt='drag' class='drag float-right'></h5><div class='card-body'><h5 class='card-title'>To: All Grades</h5><p class='card-text'> Photo club will meet today at break in C220.</p></div>                  </div>
                  <div class='card'><h5 class='card-header'>From: Ms. Best<img src='drag.png' alt='drag' class='drag float-right'></h5><div class='card-body'><h5 class='card-title'>To: All Grades</h5><p class='card-text'> Do you plan on going to Shadybrook Farm’s HorrorFest OR FallFest this Spooky Season?? Well you’re in luck, because all Holy Ghost students get a 20% discount! In order to get the discount, purchase an online ticket, and use the code ‘HGPVJM’ at checkout. Also, Shadybrook will have an area set aside for HGP students on the night of October 12. Be sure to get out and have some fun! <br><img class='picture' src='https://ehgp.holyghostprep.org/pictures/zvwn0lslewnkhqf5f17dmkl2d64zjr5scmvarsg7udvfnq16ep.png' alt='Image'><br></p></div>                  </div>
                  <div class='card'><h5 class='card-header'>From: Ms. Best<img src='drag.png' alt='drag' class='drag float-right'></h5><div class='card-body'><h5 class='card-title'>To: All Grades</h5><p class='card-text'> Tomorrow is a dress down day! Proceeds from the dress down day will go towards helping the Slay Sarcoma fundraiser.<br />
<br />
$5 to dress down and regular dress down rules apply. </p></div>                  </div>
                  <div class='card'><h5 class='card-header'>From: Mr. Crouse<img src='drag.png' alt='drag' class='drag float-right'></h5><div class='card-body'><h5 class='card-title'>To: All Grades</h5><p class='card-text'> Spanish Club TODAY at break!</p></div>                  </div>
                  <div class='card'><h5 class='card-header'>From: Dr. Saxton<img src='drag.png' alt='drag' class='drag float-right'></h5><div class='card-body'><h5 class='card-title'>To: All Grades</h5><p class='card-text'> Politics Club--Tuesday 10/15 at break in F303 <br />
<br />
 <br><img class='picture' src='https://ehgp.holyghostprep.org/pictures/53en8ctyw8jxrra1wcyeboljxmtbk2z55mstr1hz044remuc5e.jpeg' alt='Image'><br></p></div>                  </div>
                  <div class='card'><h5 class='card-header'>From: Mr. Hoban<img src='drag.png' alt='drag' class='drag float-right'></h5><div class='card-body'><h5 class='card-title'>To: All Grades</h5><p class='card-text'> Mr. Hoban's classes should report to the following rooms:<br />
<br />
4th - F201 (Mr. Vierlinck)<br />
5th - C223<br />
7/8 - F202 (Dr. O'Connor)<br />
9th - C223<br />
10th - C311 (Mr. Croskey)</p></div>                  </div>
                  <div class='card'><h5 class='card-header'>From: Dr. Ramirez<img src='drag.png' alt='drag' class='drag float-right'></h5><div class='card-body'><h5 class='card-title'>To: All Grades</h5><p class='card-text'> Club de dominó, tomorrow at break, Fr. Brown.  <br><img class='picture' src='https://ehgp.holyghostprep.org/pictures/ic7vsxww9lyj1bq7f308ip8wj1k20u17b8imot6cs1ynhir1c8.jpg' alt='Image'><br></p></div>                  </div>
                  <div class='card'><h5 class='card-header'>From: Mr. Hoban<img src='drag.png' alt='drag' class='drag float-right'></h5><div class='card-body'><h5 class='card-title'>To: All Grades</h5><p class='card-text'> Intramural Basketball games begin today at 2:45<br />
<br />
Black v Red<br />
White v Yellow<br />
<br />
Good luck!</p></div>                  </div>
                  <div class='card'><h5 class='card-header'>From: Mr. Goulet<img src='drag.png' alt='drag' class='drag float-right'></h5><div class='card-body'><h5 class='card-title'>To: All Grades</h5><p class='card-text'> Dino Club will meet at break in F203 today! ROAR!!! </p></div>                  </div>
                  <div class='card'><h5 class='card-header'>From: Ms. Best<img src='drag.png' alt='drag' class='drag float-right'></h5><div class='card-body'><h5 class='card-title'>To: All Grades</h5><p class='card-text'> SGA meeting at break in the SGA room. Please be promt. </p></div>                  </div>
                  <div class='card'><h5 class='card-header'>From: Mr. Chapman<img src='drag.png' alt='drag' class='drag float-right'></h5><div class='card-body'><h5 class='card-title'>To: All Grades</h5><p class='card-text'> Please see Mr. Chapman after the announcements:<br />
9 - Salvatore Rispo, Jamel Lindsey, Spencer Wert, Colin Todd, Ian Hendrix, Jason Brown<br />
10 - Aiden Zogorski<br />
11 - Pat McAneny, Sean McGloughlin, Ryan Coolahan<br />
12 - Luke Walsh, Jim Trifiletti</p></div>                  </div>
                  <div class='card'><h5 class='card-header'>From: Mrs. Kudla<img src='drag.png' alt='drag' class='drag float-right'></h5><div class='card-body'><h5 class='card-title'>To: Junior-Senior</h5><p class='card-text'> The following Colleges/Universities will be visiting HGP TODAY<br />
<br />
9:45 AM	Quinnipiac University	<br />
Fr. Brown<br />
<br />
9:45 AM	The Catholic University of America	<br />
Sager<br />
<br />
12:30 PM	Furman University	<br />
Fr. Brown<br />
<br />
12:30 PM	Arizona State University	<br />
Sager</p></div>                  </div>
                  <div class='card'><h5 class='card-header'>From: Mrs. McDonald<img src='drag.png' alt='drag' class='drag float-right'></h5><div class='card-body'><h5 class='card-title'>To: Freshman</h5><p class='card-text'> Brendan Boutilier, Joseph Savarese and Colin Mudrick have shadow visitors tomorrow, Friday, October 11.  Please check in with Mrs. McDonald today at break.</p></div>                  </div>
                  <div class='card'><h5 class='card-header'>From: Mrs. Campbell<img src='drag.png' alt='drag' class='drag float-right'></h5><div class='card-body'><h5 class='card-title'>To: Junior</h5><p class='card-text'> The following students have a meeting with Mrs. Campbell today in C206:<br />
<br />
5th - Cunicelli</p></div>                  </div>
                  <div class='card'><h5 class='card-header'>From: Mrs. Iuliano<img src='drag.png' alt='drag' class='drag float-right'></h5><div class='card-body'><h5 class='card-title'>To: Junior</h5><p class='card-text'> Joe Warchal please see Mrs. Iuliano 6/7 period.</p></div>                  </div>
                  <div class='card'><h5 class='card-header'>From: Mr. Eckerle<img src='drag.png' alt='drag' class='drag float-right'></h5><div class='card-body'><h5 class='card-title'>To: Senior</h5><p class='card-text'> See me at Break some time this week and consider joining the Schoology Group you were invited to join: Armentani, Behr, Bonner, Boyle, Burke, Butler, Byrne, DeLuna, El-Habr, Elliott S, Erickson, Fina, Fitzpatrick, Giuliana, Gupta, Henry, Madaio, McGrath, McManus, Mshomba, Mysore, Nycz, Pannone, Parsons, Posivak, Rosado, Van Dyke, Watanabe</p></div>                  </div>
                  <div class='card'><h5 class='card-header'>From: Ms. Conville<img src='drag.png' alt='drag' class='drag float-right'></h5><div class='card-body'><h5 class='card-title'>To: Senior</h5><p class='card-text'> Ms. Conville's 9th period Stat class please go directly to room F304 today.<br />
<br />
Thank you!</p></div>                  </div>
                  </div><p class='footer-bottom center'>EHGP Announcements redesign by Jack Pinkstone '19 and Ben Scuron '19 with advice and direction from Mr. Michael Jacobs '01, Director of Technology, and Mr. Brandon Petcaugh, Computer Science Chairman</p>
                <!-- Popout modal for settings -->
                <div class="modal fade" id="settingsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5>Settings</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form action='settings.php' method="POST">
                        <table id="settings-table">
                          <tr>
                            <td><p class="setting-label" id="drag-label">Drag Mode: </p></td>
                            <td align="right">
                                <label class="switch" id="drag-switch">
                                  <input type="checkbox" name="drag" id="drag-toggle">
                                  <span class="slider round"></span>
                                </label>
                            </td>
                          </tr>
                          <tr>
                            <td><p class="setting-label">Background: </p></td>
                            <td align="right"><input id='settings-bg-color' type='color' name='color'/></td>
                          </tr>
                          <tr>
                            <td><p class="setting-label">Themes: </p></td>
                            <td align="right">
                              <label class="switch">
                                  <input type="checkbox" name="themes" id="theme-toggle">
                                  <span class="slider round"></span>
                              </label>
                            </td>
                          </tr>
                          <tr>
                            <td><p class="setting-label">Dark Theme: </p></td>
                            <td align="right">
                              <label class="switch">
                                  <input type="checkbox" name="dark" id="dark-toggle">
                                  <span class="slider round"></span>
                              </label>
                            </td>
                          </tr>
                          <tr>
                            <td colspan="2"><hr></td>
                          </tr>
                          <tr>
                            <td><p class="setting-label">Restore to Default: </p></td>
                            <td align="right">
                                <label class="switch">
                                  <input type="checkbox" id="restore-checkbox" name="restore">
                                  <span class="slider round"></span>
                                </label>
                            </td>
                          </tr>
                        </table>
                        <!-- Footer and submit button -->
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-container="body" data-toggle="popover" data-placement="top" data-content="Toggle a slider to change your settings. All user settings are stored as cookies.">Help</button>
                            <input type="submit" value="Save" class="btn btn-primary"/>
                          </div>
                      </form>
                      </div>
                    </div>
                  </div>
                </div>
    </body>
</html>
