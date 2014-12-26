Installation:
Setting up a new TD PHP Framework application
You have downloaded TD PHP Framework and made sure you'll be able to run PHP scripts from your console (not necessary to run TD PHP Framework, but it's required for this tutorial)

Now you can follow two paths:

Create an TD PHP Framework application in a different folder and link it to the Framework libraries.
Start coding your application from this folder with the security implications that has making available to the visitors of your site all your Application models, views, 3rd party libraries and so on.
As you might have guessed you should go with the first option and create a linked TD PHP Framework application which will only expose the public folder to the world. Changing the Framework paths is really simple in TD PHP Framework, all you have to do is define in your configuration file where each component is located, but we will leave this for a future tutorial about designing an application for distributing it.

Assuming you've downloaded the framework to HOME_DIR/akelos and that you are inside the akelos directory you will check available options for setting up your new application by running

./script/setup -h

which will show us available options for the installer

Usage: setup [-sqphf --dependencies] <-d>

-deps --dependencies      Includes a copy of the framework into the application
directory. (true)
-d --directory=<value>    Destination directory for installing the application.
    -f --force                Overwrite files that already exist. (false)
    -h --help                 Show this help message.
    -p --public_html=<value>  Location where the application will be accesed by the
        webserver. ()
        -q --quiet                Suppress normal output. (false)
        -s --skip                 Skip files that already exist. (false)

        So running this command: (replace /www/htdocs with your web server public path. On some shared server it's /home/USERNAME/public_html)

        ./script/setup -d HOMEDIR/booklink -p /www/htdocs/booklink
        This will create the following structure for the booklink application:

        booklink/
        app/ << The application including controllers, views, models and installers
        config/ << Boring configuration files (will do the config via web)
        public/ << This is the only folder made public under /www/htdocs/booklink softlink
        script/ << Utils for code generation and running tests
        Note for Windows users: A soft link to booklink/public is created only on *NIX systems, so you'll need to tell your web server where to find the public path for the booklink application on your httpd.conf file by adding something like this:

        Alias /booklink "/path/to_your/booklink/public"

        <Directory "/path/to_your/booklink/public">
            Options Indexes FollowSymLinks
            AllowOverride All
            Order allow,deny
            Allow from all
    </Directory>
    and then restart your web server.

    Creating a database for your application
    Next thing you'll need is to create a database for your application. If you intend to use SQLite on PHP5 skip this step.

    Creating a MySQL database is out of the scope of this tutorial so you might need to google how to do this on your system or just try this common scenario where you can create 3 different databases one for each different environment (production, development and testing).

    mysql -u root -p

    mysql> CREATE DATABASE booklink;
    mysql> CREATE DATABASE booklink_dev;
    mysql> CREATE DATABASE booklink_tests;

    mysql> GRANT ALL ON booklink.* TO bermi@localhost IDENTIFIED BY "pass";
    mysql> GRANT ALL ON booklink_dev.* TO bermi@localhost IDENTIFIED BY "pass";
    mysql> GRANT ALL ON booklink_tests.* TO bermi@localhost IDENTIFIED BY "pass";

    mysql> FLUSH PRIVILEGES;
    mysql> exit

    If you are on a shared hosted server you might need to create it from your hosting provider control panel.

    Generating the configuration file
    Using the web installer

    Now you can visit your application configuration wizard at http://localhost/booklink

    Follow the steps in the wizard to set up your database, locales and file permissions and generate a configuration file. I'll go for a coffee while you do that so you can continue creating the booklink app.

    Manual configuration editing

    Save the files config/DEFAULT-config.php and config/DEFAULT-routes.php as config/config.php and config/routes.php and edit them following them as needed.

    You might also need to set the base rewrite path manually if you want to be able to use nice URLs by editing the file public/.htaccess and setting RewriteBase like:

    RewriteBase /booklink
    After your application has been installed correctly you'll see a welcome message at http://localhost/booklink. Now you can safely remove the framework setup files (they won't be accessible if a /config/config.php file exists)

    The booklink database structure
    Now you need to define the tables and columns where your application will hold the information about books and authors.

    When working with other developers database changes can be difficult to distribute among them. TD PHP Framework has a solution for this problem named installer or migration.

    So you will create the database using an installer in order to distribute the changes you make to the booklink database scheme from time to time. Using installers will also allow you to define your database tables and columns independently from the database vendor.

    Now you will create a file named app/installers/booklink_installer.php with the following Installer code

    <?php

    class BooklinkInstaller extends AkInstaller {

        function up_1() {

            $this->createTable('books', 'id,' . // the key
                    'title,' . // the title of the book
                    'description,' . // a description of the book
                    'author_id,' . // the author id. This is how TD PHP Framework will know how to link
                    'published_on'  // the publication date
            );

            $this->createTable('authors', 'id,' . // the key
                    'name'      // the name of the author
            );
        }

        function down_1() {
            $this->dropTables('books', 'authors');
        }

    }
    ?>
    That's enough for TD PHP Framework to create your database schema. If you just specify the column name, TD PHP Framework will default to the best data type based on database normalization conventions. If you want to have full control over your table settings, you can use php Adodb Datadict syntax

    Now we need to execute the installer with the command

    ./script/migrate Booklink install
    and that will do the trick. If we are using MySQL the database will look something like this:

    BOOKS TABLE

    +--------------+--------------+------+-----+----------------+
    | Field        | Type         | Null | Key | Extra          |
    +--------------+--------------+------+-----+----------------+
    | id           | int(11)      | NO   | PRI | auto_increment |
    | title        | varchar(255) | YES  |     |                |
    | description  | longtext     | YES  |     |                |
    | author_id    | int(11)      | YES  | MUL |                |
    | published_on | date         | YES  |     |                |
    +--------------+--------------+------+-----+----------------+
    AUTHORS TABLE

    +-------+--------------+------+-----+----------------+
    | Field | Type         | Null | Key | Extra          |
    +-------+--------------+------+-----+----------------+
    | id    | int(11)      | NO   | PRI | auto_increment |
    | name  | varchar(255) | YES  |     |                |
    +-------+--------------+------+-----+----------------+
    Models, Views and Controllers
    TD PHP Framework follows the MVC design pattern for organizing your application.

    TD PHP Framework MVC diagram.

    Your application files and the TD PHP Framework Naming conventions
    These are the conventions that empower the TD PHP Framework convention over configuration philosophy.

    Models

    Path: /app/models/
    Class Name: singular, camel cased (BankAccount, Person, Book)
    File Name: singular, underscored (bank_account.php, person.php, book.php)
    Table Name: plural, underscored (bank_accounts, people, books)
    Controllers

    Path: /app/controllers/
    Class Name: singular or pural, camel cased, ends in Controller (AccountController, PersonController)
    File Name: singular or pural, underscored, ends in _controller (account_controller.php, person_controller.php)
    Views

    Path: /app/views/ + underscoredcontrollername/ (app/views/person/)
    File Name: action name, lowercase (app/views/person/show.tpl)
    TD PHP Framework scaffolding
    TD PHP Framework comes with code generators that can cut your development time by creating fully functional scaffold code that you can use as a departure/learning point.

    Meet the Scaffold generator
    You will generate a base skeleton for interacting with the booklink database created before. In order to get this skeleton quickly you can use the scaffold generator like this

    ./script/generate scaffold Book
    and

    ./script/generate scaffold Author
    This will generate a bunch of files and folders with code that really works!. Don't trust me? Try it yourself. Point your browser to http://localhost/booklink/author and http://localhost/booklink/books to start adding authors and books. Create some records and come back for an explanation of what is going under the hood.

    The TD PHP Framework Workflow
    This is a small description of the workflow for a call to the following URL http://localhost/booklink/book/show/2

    TD PHP Framework will break up your request into three parameters according to your /config/routes.php file (more on this later)

    controller: book
    action: show
    id: 2
    Once TD PHP Framework knows about this request it will look for the file /app/controllers/book_controller.php and if found it will instantiate the class BookController

    The controller will look for a model that matches the parameter controller from the request. In this case it will look for /app/models/book.php. If found, it will create an instance of the model on the controller $this->Book attribute. If an id is on the request, it will search into the database for the Book with the id 2 and that will remain on $this->Book

    Now it will call the action show from the BookController class if it's available.

    Once the show action has been executed, the controller will look for the view file at /app/views/book/show.tpl and will render the results into the $content_for_layout variable.

    Now TD PHP Framework will look for a layout named like the controller at /app/views/layouts/book.tpl. If found it will render the layout inserting $content_for_layout content and sending the output to the browser.

    This might help you understanding the way TD PHP Framework handles your requests, so we are ready to modify the base application.

    Relating Books and Authors
    Now you are going to link authors and books (complex associations in upcoming tutorials). In order to achieve this you will use the author_id column you added to your database.

    So you will need to tell your models how they relate to each other like

    /app/models/book.php

<?php

class Book extends ActiveRecord {

    var $belongs_to = 'author'; // <- declaring the association

}
?>
    /app/models/author.php

<?php

class Author extends ActiveRecord {

    var $has_many = 'books'; // <- declaring the association

}
?>
    Now that you made the models aware of each other you will need to modify the book controller so it loads the author and the book model instances

    /app/controllers/book_controller.php

<?php

class BookController extends ApplicationController {

    var $models = 'book, author'; // <- make these models available

    // ... more BookController code

    function show() {
        // Replace "$this->book = $this->Book->find(@$this->params['id']);"
        // with this in order to find related authors.
        $this->book = $this->Book->find(@$this->params['id'], array('include' => 'author'));
    }

    // ... more BookController code
}

Next step is to show available authors when creating or editing a book. This can be achieved using the $form_options_helper by inserting the following code right after <? = $active_record_helper->error_messages_for('book');
?> on the /app/views/book/_form.tpl file

    <p>
        <label for="author">_{Author}</label><br />

        <?= $form_options_helper->select('book', 'author_id', $Author->collect($Author->find(), 'name', 'id')); ?>
    </p>
    If you have not added authors yet, go and created some right now and then visit http://locahost/boolink/book/add to check out the brand new authors select list. Go ahead and create a new book selecting an author from the list.

    Seems like the author has been saved but it its not included on the app/views/book/show.tpl view. You'll add it this code right after <? $content_columns = array_keys($Book->getContentColumns()); ?>

    <label>_{Author}:</label> <span class="static">{book.author.name?}</span><br />
    You must be screaming now about the rare _{Author} and {book.author.name?} syntax. Thats actually Sintags a small set of rules that helps on writing cleaner views and that will be compiled to standard PHP.

    Colophon
    This is all for now, I'll be improving this tutorial from time to time to add some missing features to this and other documents like:

    validations
    routes
    filters
    callbacks
    transactions
    console
    AJAX
    helpers
    web services
    testing
    distributing
    and many more...
    My apologies for any typo or grammatical error you might find. English is not my mother tongue and I would really like you to help me improving and fixing errors in this document.

    System Requirements
    A MySQL or SQLite Database
    Apache web server
    Shell access to your server
    PHP4 or PHP5
    This setting can be found on most Linux boxes and hosting providers. TD PHP Framework works in a myriad of settings but this tutorial focusses on this specific configuration.



    Advertise Here
