<!DOCTYPE html>
<html lang="ko">
<head>
  @include('includes.head', ['site_title' => 'Orion Online Judge'])
</head>
<body>
  @include('includes.header')
    
  <div class="ui grid stackable relaxed page">
    <div class="fourteen wide center aligned centered column">
      <h1 class="ui icon header">
        Semantic UI Example
      </h1>
      <p>Semantic's components allow several distinct types of definitions: elements, collections, views, modules and behaviors which cover the gamut of interface design.</p>
      <a class="ui large primary button">
         Button
        <i class="right chevron icon"></i>
      </a>
    </div>
    
    <div class="three column one column mobile demo row">
      <div class="column">
        <div class="">
          <div class="ui divider">  </div>
          <h4 class="ui header">
            <a href="">Menu</a>
          </h4><a class="anchor" id="menu"></a>
          <div class="ui vertical demo menu">
            <a class="active teal item">
              Inbox
              <div class="ui teal label">1</div>
            </a>
            <a class="item">
              Trash
              <div class="ui label">1</div>
            </a>
            <div class="item">
              <div class="ui transparent icon input">
                <input type="text" placeholder="Search mail...">
                <i class="search icon"></i>
              </div>
            </div>
          </div>
          <div class="ui fluid demo tabular menu">
            <a class="active item">
              Tab
            </a>
            <a class="item">
              Tab
            </a>
          </div>
          <div class="ui secondary vertical demo menu">
            <a class="active item">
              Inbox
            </a>
            <a class="item">
              Starred
            </a>
            <a class="item">
              Trash
            </a>
          </div>
          <div class="ui secondary pointing vertical demo menu">
            <a class="active item">
              Inbox
            </a>
            <a class="item">
              Starred
            </a>
            <a class="item">
              Trash
            </a>
          </div>
        </div>
        <div class="no">
          <div class="ui divider">  </div>
          <h4 class="ui header">
            <a href="">Divider</a>
          </h4><a class="anchor" id="divider"></a>
          <div class="ui two column stackable center aligned grid segment">
            <div class="column">
              <div class="ui button">A</div>
            </div>
            <div class="ui vertical divider">or</div>
            <div class="column">
              <div class="teal ui button">B</div>
            </div>
          </div>
        </div>
        <div class="no">
          <div class="ui divider">  </div>
          <h4 class="ui header">
            <a href="">Accordion</a>
          </h4><a class="anchor" id="accordion"></a>
          <div class="ui vertical fluid accordion menu">
            <div class="item">
              <a class="active title">
                <i class="dropdown icon"></i>
                Size
              </a>
              <div class="active content">
                <div class="ui form">
                  <div class="grouped fields">
                    <div class="field">
                      <div class="ui radio checkbox">
                        <input type="radio" name="size" value="small">
                        <label>Small</label>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui radio checkbox">
                        <input type="radio" name="size" value="medium">
                        <label>Medium</label>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui radio checkbox">
                        <input type="radio" name="size" value="large">
                        <label>Large</label>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui radio checkbox">
                        <input type="radio" name="size" value="x-large">
                        <label>X-Large</label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="item">
              <a class="title">
                <i class="dropdown icon"></i>
                Colors
              </a>
              <div class="content">
                <div class="ui form">
                  <div class="grouped fields">
                    <div class="field">
                      <div class="ui radio checkbox">
                        <input type="radio" name="color">
                        <label>Red</label>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui radio checkbox">
                        <input type="radio" name="color">
                        <label>Orange</label>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui radio checkbox">
                        <input type="radio" name="color">
                        <label>Green</label>
                      </div>
                    </div>
                    <div class="field">
                      <div class="ui radio checkbox">
                        <input type="radio" name="color">
                        <label>Blue</label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="no">
          <div class="ui divider">  </div>    
          <h4 class="ui header">
            <a href="">Message</a>
          </h4><a class="anchor" id="message"></a>
          <div class="ui message">
            <i class="close icon"></i>
            This site uses cookies
          </div>
          <div class="ui info message">
            <div class="header">We're creating your profile page</div>
            <p>It will be ready in just a second.</p>
          </div>
        </div>
      </div>
      <div class="tablet only computer only column">
        <div class="no">
          <div class="ui divider">  </div>    
          <h4 class="ui header">
            <a href="">Card</a>
          </h4><a class="anchor" id="card"></a>
          <div class="ui card">
            <div class="image dimmable dimmed">
              <div class="ui dimmer transition visible active">
                <div class="content">
                  <div class="center">
                    <div class="ui inverted button">Add Friend</div>
                  </div>
                </div>
              </div>
              <img src="//placehold.it/50">
            </div>
            <div class="content">
              <div class="header">Steve Jobes</div>
              <div class="meta">
                <a class="group">Acquaintances</a>
              </div>
              <div class="description">
                Steve Jobes is a fictional character designed to resemble someone familiar to readers.
              </div>
            </div>
            <div class="extra content">
              <a class="right floated created">
                Joined in 1998
              </a>
              <a class="friends">
                <i class="user icon"></i>
                22 Friends
              </a>
            </div>
          </div>
        </div>
        <div class="no">
          <div class="ui divider">  </div>    
          <h4 class="ui header">
            <a href="">Feed</a>
          </h4><a class="anchor" id="feed"></a>
          <div class="ui feed">
            <div class="event">
              <div class="label">
                <img src="//placehold.it/50">
              </div>
              <div class="content">
                <div class="summary">
                  <a class="user">
                    Elliot Fu
                  </a> added you as a friend
                </div>
              </div>
            </div>
            <div class="event">
              <div class="label">
                <img src="//placehold.it/50">
              </div>
              <div class="content">
                Zoe just <a>posted on your page</a>
              </div>
            </div>
          </div>
        </div>
        <div class="no">
          <div class="ui divider">  </div>    
          <h4 class="ui header">
            <a href="">Label</a>
          </h4><a class="anchor" id="label"></a>
          <div class="ui image label">
            <img src="//placehold.it/340">
            codeply@codeply.com
            <i class="delete icon"></i>
          </div>
          <a class="ui teal label">
            <i class="mail icon"></i> 23 New
          </a>
          <a class="ui tag label">Dresses</a>
        </div>
        <div class="no">
          <div class="ui divider">  </div>    
          <h4 class="ui header">
            <a href="">Step</a>
          </h4><a class="anchor" id="step"></a>
          <div class="ui fluid vertical steps">
            <a class="step">
              <i class="truck icon"></i>
              <div class="content">
                <div class="title">Shipping</div>
                <div class="description">Choose your shipping options</div>
              </div>
            </a>
            <a class="active step">
              <i class="payment icon"></i>
              <div class="content">
                <div class="title">Billing</div>
                <div class="description">Enter billing information</div>
              </div>
            </a>
            <a class="disabled step">
              <i class="info icon"></i>
              <div class="content">
                <div class="title">Confirm Order</div>
                <div class="description">Verify order details</div>
              </div>
            </a>
          </div>
        </div>
      </div>
      <div class="tablet only computer only column">
        <div class="no">
          <div class="ui divider">  </div>    
          <h4 class="ui header">
            <a href="">Dropdown</a>
          </h4><a class="anchor" id="dropdown"></a>
          <div class="ui fluid search selection dropdown">
            <input type="hidden" name="country">
            <i class="dropdown icon"></i>
            <input class="search" tabindex="0"><div class="default text">Select Country</div>
            <div class="menu" tabindex="-1">
              <div class="item" data-value="ad"><i class="ad flag"></i>Andorra</div>
              <div class="item" data-value="ae"><i class="ae flag"></i>United Arab Emirates</div>
            </div>
          </div>

          <div class="ui divider"></div>
          <div tabindex="0" class="ui searchable floating dropdown labeled icon button">
            <i class="filter icon"></i>
            <span class="text">Filter Posts</span>
            <div tabindex="-1" class="menu">
              <div class="header">
                Filter by Tag
              </div>
              <div class="item">
                <div class="ui red empty circular label"></div>
                Important
              </div>
              <div class="item">
                <div class="ui blue empty circular label"></div>
                Announcement
              </div>
              <div class="item">
                <div class="ui black empty circular label"></div>
                Cannot Fix
              </div>
              <div class="item">
                <div class="ui green empty circular label"></div>
                Discussion
              </div>
            </div>
          </div>
      </div>
        <div class="no example">
          <div class="ui divider">  </div>
          <h4 class="ui header">
            <a href="">Progress</a>
          </h4><a class="anchor" id="progress"></a>
          <div data-total="20" data-value="6" class="ui teal file demo progress active">
            <div class="bar" style="width: 25%;">
              <div class="progress"></div>
            </div>
            <div class="label">Adding 5 of 20 photos</div>
          </div>
        </div>
        <div class="no segment example">
          <div class="ui divider">  </div>
          <h4 class="ui header">
            <a href="">Segment</a>
          </h4><a class="anchor" id="segment"></a>
          <div class="ui stacked segment"></div>
          <div class="ui raised segment"></div>
          <div class="ui secondary segment"></div>
          <div class="ui tertiary segment"></div>
          <div class="ui top attached segment"></div>
          <div class="ui attached segment"></div>
          <div class="ui bottom attached segment"></div>
        </div>
        <div class="no example">
          <div class="ui divider">  </div>
          <h4 class="ui header">
            <a href="">Input</a>
          </h4><a class="anchor" id="input"></a>
          <div class="ui action left icon input">
            <i class="search icon"></i>
            <input type="text" placeholder="Search...">
            <div class="ui teal button">Search</div>
          </div>
          <div class="ui hidden divider"></div>
          <div class="ui labeled right icon input">
            <div class="ui label">
              http://
            </div>
            <input type="text" placeholder="mysite.com">
            <i class="linkify link icon"></i>
          </div>

          <div class="ui hidden divider"></div>
          <div class="ui right labeled input">
            <input type="text" placeholder="Enter categories">
            <a class="ui tag label">
              Add Tags
            </a>
          </div>
        </div>
        <div class="no example">
          <div class="ui divider">  </div>
          <h4 class="ui header">
            <a href="">Checkbox</a>
          </h4><a class="anchor" id="checkbox"></a>
          <div class="ui checkbox">
            <input type="checkbox" name="fun">
            <label>I enjoy having fun</label>
          </div>

          <div class="ui hidden divider"></div>
          <div class="ui slider checkbox">
            <input type="checkbox" name="newsletter">
            <label>Receive weekly poodle newsletter</label>
          </div>

          <div class="ui hidden divider"></div>
          <div class="ui toggle checkbox">
            <input type="checkbox" name="public">
            <label>Make my dog's profile public</label>
          </div>
        </div>
      </div>
    </div>
    <div class="ui divider">  </div>
  </div>

</body>
</html>
