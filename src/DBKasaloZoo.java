import java.sql.*;
import java.time.*;
import java.lang.*;

public class DBKasaloZoo {
	
    public static void main(String[] args) {
             
        try {
            Class.forName("com.mysql.cj.jdbc.Driver");
        } catch(ClassNotFoundException e) {
            System.out.println("Dependency error, the MySQL driver not found.");
            e.printStackTrace();
        }
        
        final String USERNAME = "", PASSWORD = "", DATABASE = ""; // Database details need to be added
        final String URL = "jdbc:mysql://dijkstra.ug.bcc.bilkent.edu.tr/" + DATABASE;
        Connection connection = null;

        try {
            connection = DriverManager.getConnection(URL, USERNAME, PASSWORD);
			
        } catch(SQLException e) 
        {
            System.out.println("Wrong username or password");
            e.printStackTrace();
        }

        if (connection != null) 
        {
            System.out.println("Connection successful");
        } 
        else 
        {
            System.out.println("Connection failed");
        }

        Statement stmt;
		
		
		try {
            stmt = connection.createStatement();
			stmt.executeUpdate("drop table if exists attending");
			stmt.executeUpdate("drop table if exists is_bday;");//+
			stmt.executeUpdate("drop table if exists pay;");//+
			stmt.executeUpdate("drop table if exists give;");//+
			stmt.executeUpdate("drop table if exists invitation;");//+
			stmt.executeUpdate("drop table if exists assigned;");//+
			stmt.executeUpdate("drop table if exists request;");//+
			stmt.executeUpdate("drop table if exists regularize_food;");//+
			stmt.executeUpdate("drop table if exists donation;");//+
			stmt.executeUpdate("drop table if exists training;");
            stmt.executeUpdate("drop table if exists animal;");//+
			stmt.executeUpdate("drop table if exists complaint;");//+
			stmt.executeUpdate("drop table if exists comment;");//+
			stmt.executeUpdate("drop table if exists food;");//++
			stmt.executeUpdate("drop table if exists cage;");//++
			stmt.executeUpdate("drop table if exists treatment;");//++
			stmt.executeUpdate("drop table if exists endangered_animal_birthday;");//+
			stmt.executeUpdate("drop table if exists group_tour;");//+
			stmt.executeUpdate("drop table if exists conservation_organization;");//+
			stmt.executeUpdate("drop table if exists educational_program;");//+
			stmt.executeUpdate("drop table if exists guide;");//+
			stmt.executeUpdate("drop table if exists event;");//+
			stmt.executeUpdate("drop table if exists treatment_request;");//+
			stmt.executeUpdate("drop table if exists keeper;"); //+
			stmt.executeUpdate("drop table if exists visitor;");//+
			stmt.executeUpdate("drop table if exists coordinator;");//+
			stmt.executeUpdate("drop table if exists veterinarian;");//+
			stmt.executeUpdate("drop table if exists employee;");//+
			stmt.executeUpdate("drop table if exists user;");//++

			//2.1 User
			stmt.executeUpdate
			(
                "create table user("
                + "user_id int auto_increment,"
                + "name varchar(32) not null,"
                + "phone_number nvarchar(32) not null unique,"
                + "email varchar(32) not null unique,"
                + "gender varchar(20) not null,"
                + "date_of_birth date not null,"
                + "password varchar(32) not null,"
				+ "primary key(user_id))"
				+ "engine innodb;"
			);
			
			//2.2 Visitor
			stmt.executeUpdate
			(
                "create table visitor("
                + "user_id int not null unique,"
				+ "money int default 0,"
                + "discount_type boolean default 0,"
                + "primary key(user_id),"
				+ "foreign key(user_id) references user(user_id) on delete cascade)"
				+ "engine innodb;"
			);
			


			//2.3 Employee
			stmt.executeUpdate
			(
				"create table employee("
				+ "user_id int not null unique,"
				+ "ssn int not null unique,"
				+ "address varchar(50) default null,"
				+ "salary int not null,"
				+ "years_worked int default 0,"
				+ "leave_days varchar(20) not null default '',"
				+ "shift_hours varchar(20) not null default '',"
				+ "bank_details varchar(50) not null default '',"
				+ "createdBy int not null,"
				+ "primary key(user_id),"
				+ "foreign key(user_id) references user(user_id) on delete cascade,"
				+ "foreign key(createdBy) references employee(user_id) on delete cascade)"
				+ "engine innodb;"
			);
			
			//2.4 Keeper
			stmt.executeUpdate
			(
				"create table keeper("
				+ "user_id int not null unique,"
				+ "speciality varchar(20) not null default '',"
				+ "primary key(user_id),"
				+ "foreign key(user_id) references employee(user_id) on delete cascade)"
				+ "engine innodb;"
			);
			
			//2.5 Veterinarian
			stmt.executeUpdate
			(
				"create table veterinarian("
				+ "user_id int not null unique,"
				+ "certificate varchar(50) not null default '',"
				+ "branch varchar(20) not null default '', "
				+ "primary key(user_id),"
				+ "foreign key(user_id) references employee(user_id) on delete cascade)"
				+ "engine innodb;"
			);
			
			//2.6 Treatment Request
			stmt.executeUpdate
			(
				"create table treatment_request("
				+ "request_id int auto_increment,"
				+ "vet_id int not null,"
				+ "request_date date not null,"
				+ "findings varchar(120) not null default '',"
				+ "isAccepted boolean not null default 0,"
				+ "primary key(request_id),"
				+ "foreign key(vet_id) references veterinarian(user_id) on delete cascade)"
				+ "engine innodb;"
			);
			
			//2.7 Coordinator
			stmt.executeUpdate
			(
				"create table coordinator("
				+ "user_id int not null unique,"
				+ "rank varchar(20) not null default '',"
				+ "area_managed varchar(20) not null default '',"
				+ "primary key(user_id),"
				+ "foreign key(user_id) references employee(user_id) on delete cascade)"
				+ "engine innodb;"
			);
			
			//2.8 Event
			stmt.executeUpdate
			(
				"create table event("
				+ "user_id int not null,"
				+ "event_id int not null unique,"
				+ "start_date date not null,"
				+ "duration varchar(10) not null,"
				+ "primary key(user_id, event_id),"
				+ "foreign key(user_id) references coordinator(user_id) on delete cascade)"
				+ "engine innodb;"
			);
			
			//2.9 Guide
			stmt.executeUpdate
			(
				"create table guide("
				+ "user_id int not null unique,"
				+ "certificate varchar(50) not null default '',"
				+ "daily_tour_number int not null default 1,"
				+ "primary key(user_id),"
				+ "foreign key(user_id) references employee(user_id) on delete cascade)"
				+ "engine innodb;"
			);
			
			//2.10 Educational Program
			stmt.executeUpdate
			(
				"create table educational_program("
				+ "user_id int not null,"
				+ "event_id int not null unique,"
				+ "place varchar(20) not null default '',"
				+ "topic varchar(10) not null default '',"
				+ "primary key(user_id, event_id),"
				+ "foreign key(user_id, event_id) references event(user_id, event_id) on delete cascade)"
				+ "engine innodb;"
			);
			
			//2.11 Conservation Organization
			stmt.executeUpdate
			(
				"create table conservation_organization("
				+ "user_id int not null,"
				+ "event_id int not null unique,"
				+ "fundings decimal(19,2) not null default 0,"
				+ "participant_count int not null default 0,"
				+ "name varchar(50) not null default '',"
				+ "primary key(user_id, event_id),"
				+ "foreign key(user_id, event_id) references event(user_id, event_id) on delete cascade)"
				+ "engine innodb;"
			);
			

			//2.12 Group Tour
			stmt.executeUpdate
			(
				"create table group_tour("
				+ "user_id int not null,"
				+ "event_id int not null unique,"
				+ "guide_id int not null,"
				+ "capacity int not null default 0,"
				+ "participant_count int not null default 0,"
				+ "primary key(user_id, event_id),"
				+ "foreign key(user_id, event_id) references event(user_id, event_id) on delete cascade,"
				+ "foreign key(guide_id) references guide(user_id) on delete cascade)"
				+ "engine innodb;"
			);
			
			//2.13 Endangered Animal Birthday
			stmt.executeUpdate
			(
				"create table endangered_animal_birthday("
				+ "user_id int not null,"
				+ "event_id int not null unique,"
				+ "party_type varchar(20) not null default '',"
				+ "number_of_birthday_animals smallint not null default 0,"
				+ "primary key(user_id, event_id),"
				+ "foreign key(user_id, event_id) references event(user_id, event_id) on delete cascade)"
				+ "engine innodb;"
			);
			
			//2.14 Treatment
			stmt.executeUpdate
			(
				"create table treatment("
				+ "treatment_id int auto_increment,"
				+ "medicine varchar(120) not null default '',"
				+ "recommended_diet varchar(20) not null default '',"
				+ "treatment_duration varchar(20) not null default '',"
				+ "primary key(treatment_id))"
				+ "engine innodb;"
			);
			
			//2.15 Cage
			stmt.executeUpdate
			(
				"create table cage("
				+ "cage_id int auto_increment,"
				+ "animal_count smallint not null default 0,"
				+ "cage_type varchar(20) not null default '',"
				+ "last_care_date date not null,"
				+ "feed_time time not null,"
				+ "location varchar(20) not null,"
				+ "primary key(cage_id))"
				+ "engine innodb;"
			);
			
			//2.16 Food
			stmt.executeUpdate
			(
				"create table food("
				+ "barcode int not null,"
				+ "type varchar(20) not null default '',"
				+ "calories varchar(20) not null default 0,"
				+ "stock int not null default 0,"
				+ "name varchar(20)not null default '',"
				+ "primary key(barcode))"
				+ "engine innodb;"
			);
			
			//2.17 Comment
			stmt.executeUpdate
			(
				"create table comment("
				+ "comment_id int auto_increment,"
				+ "comment_text nvarchar(200) not null default '',"
				+ "date date not null,"
				+ "anonymity boolean not null default 0,"
				+ "star_rate int not null default 5,"
				+ "user_id int not null,"
				+ "vis_id int not null,"
				+ "event_id int not null,"
				+ "primary key(comment_id),"
				+ "foreign key(user_id, event_id) references group_tour(user_id, event_id) on delete cascade,"
				+ "foreign key(vis_id) references visitor(user_id) on delete cascade)"
				+ "engine innodb;"
			);
			
			//2.18 Complaint
			stmt.executeUpdate
			(
				"create table complaint("
				+ "form_id int auto_increment,"
				+ "form_text nvarchar(200) not null default '',"
				+ "date date not null,"
				+ "about varchar(20) not null default '',"
				+ "coor_id int default null,"
				+ "vis_id int not null,"
				+ "respond_text nvarchar(200) not null default '',"
				+ "primary key(form_id),"
				+ "foreign key(coor_id) references coordinator(user_id) on delete cascade,"
				+ "foreign key(vis_id) references visitor(user_id) on delete cascade)"
				+ "engine innodb;"
			);
			
			//2.19 Animal
			stmt.executeUpdate
			(
				"create table animal("
				+ "animal_id int auto_increment,"
				+ "trainer_id int not null,"
				+ "cage_id int not null,"
				+ "species varchar(20) not null default '',"
				+ "date_of_birth date not null,"
				+ "last_health_check date not null,"
				+ "name varchar(20) not null default '',"
				+ "gender varchar(10) not null default '',"
				+ "weight decimal(6,2) not null default 0,"
				+ "origin varchar(20) not null default '',"
				+ "diet varchar(20) not null default '',"
				+ "isEndangered boolean not null default 0,"
				+ "habitat varchar(20) not null default '',"
				+ "height decimal(4,2) not null default 0,"
				+ "status varchar(20) not null default '',"
				+ "primary key(animal_id),"
				+ "foreign key(trainer_id) references keeper(user_id) on delete cascade,"
				+ "foreign key(cage_id) references cage(cage_id) on delete cascade)"
				+ "engine innodb;"
			);
			
			//2.28 Trainer
			stmt.executeUpdate
			(
				"create table training("
				+ "training_id int auto_increment,"
				+ "animal_id int not null,"
				+ "trainer_id int not null,"
				+ "training_date date not null,"
				+ "training_topic varchar(40) not null default '',"
				+ "primary key(training_id),"
				+ "foreign key(trainer_id) references animal(trainer_id) on delete cascade,"
				+ "foreign key(animal_id) references animal(animal_id) on delete cascade)"
				+ "engine innodb;"
			);
			
			//2.20 Donation
			stmt.executeUpdate
			(
				"create table donation("
				+ "user_id int not null,"
				+ "event_id int not null,"
				+ "coor_id int not	null,"
				+ "amount decimal(19,2) not null default 0,"
				+ "foreign key(user_id) references visitor(user_id) on delete cascade,"
				+ "foreign key(coor_id,event_id) references conservation_organization(user_id, event_id) on delete cascade)"
				+ "engine innodb;"
			);
			
			//2.21 Regularize Food
			stmt.executeUpdate
			(
				"create table regularize_food("
				+ "cage_id int not null,"
				+ "barcode int not null,"
				+ "feed_time datetime not null,"
				+ "amount decimal(19,2) not null,"
				+ "user_id int not null,"
				+ "primary key(cage_id, barcode, feed_time),"
				+ "foreign key(cage_id) references cage(cage_id) on delete cascade,"
				+ "foreign key(user_id) references keeper(user_id) on delete cascade,"
				+ "foreign key(barcode) references food(barcode) on delete cascade)"
				+ "engine innodb;"
			);
			
			//2.22 Request
			stmt.executeUpdate
			(
				"create table request("
				+ "animal_id int not null,"
				+ "request_id int auto_increment,"
				+ "user_id int not null,"
				+ "primary key(request_id),"
				+ "foreign key(animal_id) references animal(animal_id) on delete cascade,"
				+ "foreign key(request_id) references treatment_request(request_id) on delete cascade,"
				+ "foreign key(user_id) references animal(trainer_id) on delete cascade)"
				+ "engine innodb;"
			);
			
			//2.23 Assigned
			stmt.executeUpdate
			(
				"create table assigned("
				+ "keep_id int not null,"
				+ "coor_id int not null,"
				+ "cage_id int not null,"
				+ "primary key(cage_id),"
				+ "foreign key(keep_id) references keeper(user_id) on delete cascade,"
				+ "foreign key(coor_id) references coordinator(user_id) on delete cascade,"
				+ "foreign key(cage_id) references cage(cage_id) on delete cascade)"
				+ "engine innodb;"
			);
			
			//2.24 Invitation
			stmt.executeUpdate
			(
				"create table invitation("
				+ "vet_id int not null,"
				+ "coor_id int not null,"
				+ "event_id int not null,"
				+ "isAccepted boolean not null default 0,"
				+ "primary key(vet_id, coor_id, event_id),"
				+ "foreign key(vet_id) references veterinarian(user_id) on delete cascade,"
				+ "foreign key(coor_id, event_id) references educational_program(user_id, event_id) on delete cascade)"
				+ "engine innodb;"
			);
			
			//2.25 Give
			stmt.executeUpdate
			(
				"create table give("
				+ "animal_id int not null,"
				+ "treatment_id int not null,"
				+ "request_id int not null,"
				+ "primary key(request_id),"
				+ "foreign key(animal_id) references animal(animal_id) on delete cascade,"
				+ "foreign key(treatment_id) references treatment(treatment_id) on delete cascade,"
				+ "foreign key(request_id) references treatment_request(request_id) on delete cascade)"
				+ "engine innodb;"
			);
			
			//2.26 Pay
			stmt.executeUpdate
			(
				"create table pay("
				+ "coor_id int not null,"
				+ "event_id int not null,"
				+ "user_id int not null,"
				+ "requested_amount decimal(19,2) not null default 0,"
				+ "primary key(coor_id, event_id, user_id),"
				+ "foreign key(coor_id, event_id) references group_tour(user_id, event_id) on delete cascade,"
				+ "foreign key(user_id) references visitor(user_id) on delete cascade)"
				+ "engine innodb;"
			);
			
			//2.27 is Birthday
			stmt.executeUpdate
			(
				"create table is_bday("
				+ "animal_id int not null,"
				+ "coor_id int not null,"
				+ "event_id int not null,"
				+ "primary key(animal_id, coor_id, event_id),"
				+ "foreign key(animal_id) references animal(animal_id) on delete cascade,"
				+ "foreign key(coor_id, event_id) references endangered_animal_birthday(user_id, event_id) on delete cascade)"
				+ "engine innodb;"
			);	
			
			//2.29 Attending
			stmt.executeUpdate
			(
				"create table attending("
				+ "coor_id int not null,"
				+ "event_id int not null,"
				+ "user_id int not null,"
				+ "primary key(coor_id, event_id, user_id),"
				+ "foreign key(coor_id, event_id) references endangered_animal_birthday(user_id, event_id) on delete cascade,"
				+ "foreign key(user_id) references visitor(user_id) on delete cascade)"
				+ "engine innodb;"
			);
			
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
			//2.1 user	
	// coordinators
			stmt.executeUpdate("insert into user values(default , \"Purigrim Hallowedgrain\" , \"05432736137\" , \"coordinator@hotmail.com\" , \"male\" ,  \"1952-09-03\", \"test123\" )");
			stmt.executeUpdate("insert into user values(default , \"Festerban Stormgust\" , \"08187473151\" , \"has50757@zwoho.com\" , \"male\" ,  \"1953-05-13\", \"password2\" )");
			stmt.executeUpdate("insert into user values(default , \"Skynux Hardvigor\" , \"07709601889\" , \"qtr02269@zwoho.com\" , \"male\" ,  \"1954-09-30\", \"password3\" )");
			stmt.executeUpdate("insert into user values(default , \"Garalax Longfury\" , \"01568994973\" , \"cyc11100@cuoly.com\" , \"male\" ,  \"1955-10-21\", \"password4\" )");
			stmt.executeUpdate("insert into user values(default , \"Rulaz Wolfriver\" , \"04848779407\" , \"opf89953@cuoly.com\" , \"male\" ,  \"1956-08-03\", \"password5\" )");
	// keepers
			stmt.executeUpdate("insert into user values(default , \"Abasalax Daysprinter\" , \"01401272754\" , \"keeper@hotmail.com\" , \"male\" ,  \"1957-11-14\", \"test123\" )");
			stmt.executeUpdate("insert into user values(default , \"Jidred Deepbane\" , \"07280246404\" , \"lka32075@zwoho.com\" , \"female\" ,  \"1962-01-22\", \"password7\" )");
			stmt.executeUpdate("insert into user values(default , \"Rubus Covenwatcher\" , \"07364181143\" , \"lvx95692@zwoho.com\" , \"female\" ,  \"1967-02-17\", \"password8\" )");
			stmt.executeUpdate("insert into user values(default , \"Nasuruxa Solidchaser\" , \"01566935337\" , \"tnv92990@zwoho.com\" , \"female\" ,  \"1968-02-11\", \"password9\" )");
			stmt.executeUpdate("insert into user values(default , \"Kreriyes Wisewolf\" , \"01192011136\" , \"bnf28990@zwoho.com\" , \"female\" ,  \"1968-06-09\", \"password10\" )");
	//veterinarians
			stmt.executeUpdate("insert into user values(default , \"Ferraz Stormmantle\" , \"03791641014\" , \"veterinarian@hotmail.com\" , \"female\" ,  \"1969-05-13\", \"test123\" )");
			stmt.executeUpdate("insert into user values(default , \"Shivix Sacredvalor\" , \"03874885249\" , \"dey88240@cuoly.com\" , \"female\" ,  \"1971-08-13\", \"password12\" )");
			stmt.executeUpdate("insert into user values(default , \"Kyrhazi Pyrestar\" , \"08400130130\" , \"ist53416@zwoho.com\" , \"male\" ,  \"1983-04-13\", \"password13\" )");
			stmt.executeUpdate("insert into user values(default , \"Fyrique Coldspell\" , \"02028613389\" , \"pmf97193@cuoly.com\" , \"male\" ,  \"1987-09-09\", \"password14\" )");
			stmt.executeUpdate("insert into user values(default , \"Enegone Duskchaser\" , \"09969178940\" , \"vsa35293@eoopy.com\" , \"male\" ,  \"1992-02-05\", \"password15\" )");
	//visitors
			stmt.executeUpdate("insert into user values(default , \"Fargon Moonblade\" , \"04298751192\" , \"visitor@hotmail.com\" , \"male\" ,  \"1992-12-10\", \"test123\" )");
			stmt.executeUpdate("insert into user values(default , \"Garadas Deepfallow\" , \"04734361971\" , \"foy66426@cuoly.com\" , \"male\" ,  \"1995-12-16\", \"password17\" )");
			stmt.executeUpdate("insert into user values(default , \"Arphoz Spiritstrider\" , \"07487190468\" , \"mhu94939@cuoly.com\" , \"male\" ,  \"1996-10-28\", \"password18\" )");
			stmt.executeUpdate("insert into user values(default , \"Eredas Steelthorne\" , \"09049485687\" , \"ctx76990@zwoho.com\" , \"male\" ,  \"2005-08-30\", \"password19\" )");
			stmt.executeUpdate("insert into user values(default , \"Inguthal Thunderbash\" , \"08312480860\" , \"raq75844@eoopy.com\" , \"male\" ,  \"2010-10-13\", \"password20\" )");
	//guide
			stmt.executeUpdate("insert into user values(default , \"Tiyamura Slatescar\" , \"08611822809\" , \"guide@hotmail.com\" , \"female\" ,  \"1998-01-24\", \"test123\" )");
			stmt.executeUpdate("insert into user values(default , \"Demaruse Plainwind\" , \"08291593818\" , \"ihq35553@eoopy.com\" , \"female\" ,  \"1998-10-24\", \"password22\" )");
			stmt.executeUpdate("insert into user values(default , \"Tunesh Lowcloud\" , \"07529291156\" , \"mhx03798@zwoho.com\" , \"female\" ,  \"1999-11-24\", \"password23\" )");
			
			// 2.2 visitor
			stmt.executeUpdate("insert into visitor values(16 , 100 , 0 )");
			stmt.executeUpdate("insert into visitor values(17 , 150 , 0 )");
			stmt.executeUpdate("insert into visitor values(18 , 1000 , 0 )");
			stmt.executeUpdate("insert into visitor values(19 , default , 1 )");
			stmt.executeUpdate("insert into visitor values(20 , default , 1 )");
			
			// 2.3 employee
			stmt.executeUpdate("insert into employee values( 1 , 1 , \"834 Glenwood St. Jackson, NJ 08527\" , 5000 , 6 , \"Monday-Saturday\" , \"08:00 - 22:00\" , \"15820796507566095529569105\" , 1 )");
			stmt.executeUpdate("insert into employee values( 2 , 2 , \"17 Rockaway Street Annapolis, MD 21401\" , 5000 , 3 , \"Tuesday-Sunday\" , \"08:00 - 22:00\" , \"41988999292713125087476467\" , 1 )");
			stmt.executeUpdate("insert into employee values( 3 , 3 , \"57 North Studebaker Road Fleming Island, FL 32003\" , 5000 , 5 , \"Wednesday-Saturday\" , \"08:00 - 22:00\" , \"28484075599305535780804214\" , 1 )");
			stmt.executeUpdate("insert into employee values( 4 , 4 , \"174 Redwood Ave. Williamstown, NJ 08094\" , 5000 , 6 , \"Thursday-Sunday\" , \"08:00 - 22:00\" , \"55387017114420883226675316\" , 1 )");
			stmt.executeUpdate("insert into employee values( 5 , 5 , \"975 Addison Drive Clementon, NJ 08021\" , 5000 , 7 , \"Saturday-Sunday\" , \"08:00 - 22:00\" , \"96289252868686270157484550\" , 1 )");
			stmt.executeUpdate("insert into employee values( 6 , 6 , \"529 Maple St. Lincoln, NE 68506\" , 3000 , 5 , \"Sunday\" , \"08:00 - 22:00\" , \"73769458847915045999132120\" , 1 )");
			stmt.executeUpdate("insert into employee values( 7 , 7 , \"151 Peninsula Dr. Macomb, MI 48042\" , 3000 , 3 , \"Sunday\" , \"08:00 - 22:00\" , \"42730088027502703889469560\" , 1 )");
			stmt.executeUpdate("insert into employee values( 8 , 8 , \"384 Peachtree Street Villa Park, IL 60181\" , 3000 , 1 , \"Sunday\" , \"08:00 - 22:00\" , \"47019572545286718042634731\" , 1 )");
			stmt.executeUpdate("insert into employee values( 9 , 9 , \"566 Mayflower Drive Kaukauna, WI 54130\" , 3000 , 4 , \"Sunday\" , \"08:00 - 22:00\" , \"63679678456651188824362153\" , 1 )");
			stmt.executeUpdate("insert into employee values( 10 , 10 , \"98 Smith Store Drive New Hyde Park, NY 11040\" , 3000 , 4 , \"Sunday\" , \"08:00 - 22:00\" , \"77058282024421129246479465\" , 1 )");
			stmt.executeUpdate("insert into employee values( 11 , 11 , \"9784 Studebaker Street Marlton, NJ 08053\" , 4000 , 2 , \"Sunday\" , \"08:00 - 22:00\" , \"59591083049915209155865125\" , 1 )");
			stmt.executeUpdate("insert into employee values( 12 , 12 , \"109 Old York Lane Groton, CT 06340\" , 4000 , 5 , \"Sunday\" , \"08:00 - 22:00\" , \"59907280602418252099381859\" , 1 )");
			stmt.executeUpdate("insert into employee values( 13 , 13 , \"7862 Bellevue St. Richardson, TX 75080\" , 4000 , 2 , \"Sunday\" , \"08:00 - 22:00\" , \"89345044000119959453852493\" , 1 )");
			stmt.executeUpdate("insert into employee values( 14 , 14 , \"49 Pheasant Dr. Buckeye, AZ 85326\" , 4000 , 3 , \"Sunday\" , \"08:00 - 22:00\" , \"86914722499451790694704260\" , 1 )");
			stmt.executeUpdate("insert into employee values( 15 , 15 , \"49 Hanover Street Jupiter, FL 33458\" , 4000 , 4 , \"Sunday\" , \"08:00 - 22:00\" , \"83909814030878513089602217\" , 1 )");
			stmt.executeUpdate("insert into employee values( 21 , 16 , \"398 Dunbar Dr. Fredericksburg, VA 22405\" , 1000 , 1 , \"Monday\" , \"08:00 - 22:00\" , \"68385666318459685332238285\" , 1 )");
			stmt.executeUpdate("insert into employee values( 22 , 17 , \"89 Gregory Drive Odenton, MD 21113\" , 1000 , 1 , \"Tuesday\" , \"08:00 - 22:00\" , \"42705549662981572207961969\" , 1 )");
			stmt.executeUpdate("insert into employee values( 23 , 18 , \"127 North Taylor Drive Fernandina Beach, FL 32034\" , 1000 , 1 , \"Wednesday\" , \"08:00 - 22:00\" , \"82260948202456460656616478\" , 1 )");
			
			//2.4 keeper
			stmt.executeUpdate("insert into keeper values(6 , \"water\" )");
			stmt.executeUpdate("insert into keeper values(7 , \"land\" )");
			stmt.executeUpdate("insert into keeper values(8 , \"air\" )");
			stmt.executeUpdate("insert into keeper values(9 , \"land\" )");
			stmt.executeUpdate("insert into keeper values(10 , \"water\" )");
			
			// 2.5 Veterinarian
			stmt.executeUpdate("insert into veterinarian values(11 , \"Cardiology\" , \"Avian\" )");
			stmt.executeUpdate("insert into veterinarian values(12 , \"Dentistry\" , \"Equine\" )");
			stmt.executeUpdate("insert into veterinarian values(13 , \"Neurology\" , \"Feline\" )");
			stmt.executeUpdate("insert into veterinarian values(14 , \"Oncology\" , \"Reptile\" )");
			stmt.executeUpdate("insert into veterinarian values(15 , \"Orthopaedics\" , \"Canine\" )");
			
			// 2.6 Treatment Request
			stmt.executeUpdate("insert into treatment_request values(default , 11 , \"2018-11-24\" , \"molt\" , 1 )");
			stmt.executeUpdate("insert into treatment_request values(default , 12 , \"2019-10-05\" , \"eye burring\" , 1 )");
			stmt.executeUpdate("insert into treatment_request values(default , 13 , \"2017-01-12\" , \"cold\" , 0 )");
			
			// 2.7 Coordinator
			stmt.executeUpdate("insert into coordinator values(1 , \"Coordinator\" , \"North\" )");
			stmt.executeUpdate("insert into coordinator values(2 , \"Coordinator\" , \"South\" )");
			stmt.executeUpdate("insert into coordinator values(3 , \"Coordinator\" , \"West\" )");
			stmt.executeUpdate("insert into coordinator values(4 , \"Coordinator\" , \"East\" )");
			stmt.executeUpdate("insert into coordinator values(5 , \"Head Coordinator\" , \"Center\" )");
			
			//2.8 Event
	// educational_program
			stmt.executeUpdate("insert into event values(1 , 1 , \"2012-04-01\" , \"3 hours\")");
			stmt.executeUpdate("insert into event values(1 , 2 , \"2013-08-25\" , \"3 hours\")");
	// conservation_organization
			stmt.executeUpdate("insert into event values(2 , 3 , \"2016-09-18\" , \"6 hours\")");
			stmt.executeUpdate("insert into event values(2 , 4 , \"2018-02-17\" , \"6 hours\")");
	// group_tour
			stmt.executeUpdate("insert into event values(3 , 5 , \"2020-05-04\" , \"1 hour\")");
			stmt.executeUpdate("insert into event values(4 , 6 , \"2020-11-22\" , \"1 hour\")");
	// endangered_animal_birthday
			stmt.executeUpdate("insert into event values(4 , 7 , \"2019-10-03\" , \"3 hours\")");
			stmt.executeUpdate("insert into event values(4 , 8 , \"2014-10-11\" , \"3 hours\")");
			
			//2.9 Guide
			stmt.executeUpdate("insert into guide values(21 , \"EastguidesWest\" , 30)");
			stmt.executeUpdate("insert into guide values(22 , \"International Guide Academy\" , 30)");
			stmt.executeUpdate("insert into guide values(23 , \"International Tour Management Institute\" , 30)");
			
			//2.10 Educational Program
			stmt.executeUpdate("insert into educational_program values(1 , 1 , \"West Area A Building\" , \"Oncology\" )");
			stmt.executeUpdate("insert into educational_program values(1 , 2 , \"West Area B Building\" , \"Neurology\" )");
			
			//2.11 Conservation Organization
			stmt.executeUpdate("insert into conservation_organization values(2 , 3 , 1000.0, 100, \"The Nature Conservancy\")");
			stmt.executeUpdate("insert into conservation_organization values(2 , 4 , 1000.0, 100, \"Ducks Unlimited\")");
			
			//2.12 Group Tour
			stmt.executeUpdate("insert into group_tour values(3 , 5 , 21 , 100, 50)");
			stmt.executeUpdate("insert into group_tour values(4 , 6 , 22 , 100, 50)");
			
			//2.13 Endangered Animal Birthday
			stmt.executeUpdate("insert into endangered_animal_birthday values(4 , 7 , \"Pool\", 2 )");
			stmt.executeUpdate("insert into endangered_animal_birthday values(4 , 8 , \"Land\", 2 )");
			
			//2.14 Treatment
			stmt.executeUpdate("insert into treatment values(default , \"Vaccination\" , \"NaN\", \"1 hour\")");
			stmt.executeUpdate("insert into treatment values(default , \"Surgery\" , \"Only Liquid\", \"3 hours\")");
			stmt.executeUpdate("insert into treatment values(default , \"Resting\" , \"NaN\", \"2 week\")");
			stmt.executeUpdate("insert into treatment values(default , \"Taking Pill\" , \"Vegan Diet\", \"1 week\")");
			
			//2.15 Cage
			stmt.executeUpdate("insert into cage values(default , 5 , \"Forest\", \"2021-05-11\" , \"19:00\" , \"North\")");
			stmt.executeUpdate("insert into cage values(default , 5 , \"Forest\", \"2021-05-11\" , \"19:02\" , \"North\")");
			stmt.executeUpdate("insert into cage values(default , 5 , \"Forest\", \"2021-05-11\" , \"18:58\" , \"North\")");
			stmt.executeUpdate("insert into cage values(default , 5 , \"savanna\", \"2021-05-11\" , \"18:57\" , \"South\")");
			stmt.executeUpdate("insert into cage values(default , 5 , \"Water\", \"2021-05-11\" , \"19:03\" , \"South\")");
			stmt.executeUpdate("insert into cage values(default , 5 , \"Water\", \"2021-05-11\" , \"19:02\" , \"West\")");
			
			//2.16 Food
			stmt.executeUpdate("insert into food values(1111 , \"Meat\", \"200\" , 1000 , \"For Jaguar\")");
			stmt.executeUpdate("insert into food values(1112 , \"Eucalypt Leaves\", \"10\" , 1000 , \"For Koala\")");
			stmt.executeUpdate("insert into food values(1113 , \"Fruits\", \"20\" , 1000 , \"For Monkey\")");
			stmt.executeUpdate("insert into food values(1114 , \"Fish meat\", \"200\" , 1000 , \"For Eagle\")");
			stmt.executeUpdate("insert into food values(1115 , \"Bamboo\", \"120\" , 1000 , \"For Panda\")");
			
			//2.17 Comment
			stmt.executeUpdate("insert into comment values(default , \"We have been to many group tour but this one was amazing.\" , \"2019-06-26\", 1 , 5 , 3 , 16 , 5 )");
			stmt.executeUpdate("insert into comment values(default , \"We had a great family adventure today on the Kasalo Zoo during the group tour. It was an adventure suitable for our whole family of 4.\" , \"2020-09-16\", 0 , 5 , 4 , 16 , 6 )");
			//stmt.executeUpdate("insert into comment values(default , \"It was lovely and nice\" , \"2019-11-29\", 0 , 5 , 4 , 17 , 6 )");
			
			//2.18 Complaint
			stmt.executeUpdate("insert into complaint values(default , \"Less number of animals and species\" , \"2020-01-25\" , \"Variety\" , 1 , 16 , \"Thanks for your complaint we are also aware of that problem and we will do what we can\")");
			stmt.executeUpdate("insert into complaint values(default , \"The collection of animals is small and not much unique due to number of them\" , \"2021-01-06\" , \"Number of animals\" , 2 , 17 , \"Thanks for your complaint we are also aware of that problem and we will do what we can\")");
			
			//2.19 Animal
			stmt.executeUpdate("insert into animal values(default , 6 , 1 , \"Proboscis Monkey\" , \"2005-05-11\" , \"2020-05-05\" , \"Tuzgosh\" , \"male\", 66.0 , \"Borneo Island\" , \"Omnivore\", 1 , \"Jungle\" , 1.65 , \"alive\" )");
			stmt.executeUpdate("insert into animal values(default , 6 , 2 , \"Phascolarcto\" ,  \"2007-03-04\", \"2020-05-20\" , \"Utkusum\" , \"male\", 5.0 , \"Sydney\" , \"Herbivores\", 1 , \"Jungle\" , 0.30 , \"alive\" )");
			stmt.executeUpdate("insert into animal values(default , 7 , 4 , \"Panthera Onca\" ,  \"2010-04-20\", \"2020-03-24\" , \"Yeet\" , \"male\", 86.0 , \"Portuguese\" , \"Carnivore\", 0 , \"Forest\" , 0.75 , \"alive\" )");
			stmt.executeUpdate("insert into animal values(default , 8 , 3 , \"Golden Eagle\" ,  \"2012-01-01\", \"2020-01-01\" , \"Muzzolini\" , \"male\", 4.5 , \"Mexico\" , \"Carnivore\", 0 , \"Mountains\" , 0.70 , \"alive\" )");
			stmt.executeUpdate("insert into animal values(default , 8 , 1 , \"A. Melanoleuca\" ,  \"2018-11-24\", \"2020-10-12\" , \"Kaede\" , \"female\", 75.0 , \"China\" , \"Carnivore\", 1 , \"Forest\" , 0.55 , \"alive\" )");
			stmt.executeUpdate("insert into animal values(default , 6 , 2 , \"species\" ,  \"1999-11-24\", \"2020-09-10\" , \"animal_name2\" , \"gender\", 100.0 , \"origin_animal\" , \"diet_animal\", 1 , \"habitat_animal\" , 5.2 , \"status_animal\" )");
			stmt.executeUpdate("insert into animal values(default , 7 , 2 , \"species\" ,  \"1999-11-24\", \"1999-11-24\" , \"animal_name3\" , \"gender\", 100.0 , \"origin_animal\" , \"diet_animal\", 1 , \"habitat_animal\" , 5.2 , \"status_animal\" )");
			
			//Animal DELETION
			stmt.executeUpdate("delete from animal where name = \"animal_name2\" ");
			//Animal UPDATE
			stmt.executeUpdate("update animal set trainer_id = 10, cage_id = 4, date_of_birth = \"2001-04-24\", last_health_check = \"2020-07-04\", species = \"Panthera Leo\", name = \"Reis\" , gender = \"male\" , weight = 185.5 , origin = \"Africa\" , diet = \"Omnivore\" , isEndangered = 0 , habitat = \"savanna\" , height = 1.85 , status = \"alive\" where name = \"animal_name3\" " );
		
		
			//2.28 Trainer
			stmt.executeUpdate("insert into training values(default , 1 , 6 , \"2022-11-20\" , \"Companion\" )");
			stmt.executeUpdate("insert into training values(default , 1 , 6 , \"2020-12-05\" , \"Hunting\" )");
			stmt.executeUpdate("insert into training values(default , 3 , 7 , \"2021-05-14\" , \"Food\" )");
			stmt.executeUpdate("insert into training values(default , 4 , 8 , \"2020-11-24\" , \"Running\" )");
			
			//2.20 Donation
			stmt.executeUpdate("insert into donation values(16 , 3 , 2 , 1000.0 )");
			stmt.executeUpdate("insert into donation values(17 , 3 , 2 , 1000.0 )");
			stmt.executeUpdate("insert into donation values(18 , 4 , 2 , 1000.0 )");
			
			//2.21 Regularize Food
			stmt.executeUpdate("insert into regularize_food values(4 , 1111 , \"2020-12-05 12:00\" , 12.0 , 6 )");
			stmt.executeUpdate("insert into regularize_food values(2 , 1112 , \"2021-05-15 12:00\" , 12.0 , 7 )");
			stmt.executeUpdate("insert into regularize_food values(3 , 1113 , \"2020-09-24 12:00\" , 12.0 , 8 )");
			
			//2.22 Request
			stmt.executeUpdate("insert into request values(1 , default , 6 )");
			stmt.executeUpdate("insert into request values(2 , default , 8 )");
			
			//2.23 Assigned
			stmt.executeUpdate("insert into assigned values(6 , 1 , 1 )");
			stmt.executeUpdate("insert into assigned values(6 , 2 , 2 )");
			stmt.executeUpdate("insert into assigned values(7 , 1 , 4 )");
			stmt.executeUpdate("insert into assigned values(7 , 3 , 5 )");
			stmt.executeUpdate("insert into assigned values(8 , 4 , 3 )");
			
			//2.24 Invitation
			stmt.executeUpdate("insert into invitation values(11 , 1 , 1 , 1 )");
			stmt.executeUpdate("insert into invitation values(12 , 1 , 2 , 0 )");
			
			//2.25 Give
			stmt.executeUpdate("insert into give values(1, 1, 1 )");
			stmt.executeUpdate("insert into give values(2, 2, 2 )");
			
			//2.26 Pay
			stmt.executeUpdate("insert into pay values(3 , 5 , 16 , 10.0 )");
			stmt.executeUpdate("insert into pay values(4 , 6 , 16 , 10.0 )");
			stmt.executeUpdate("insert into pay values(4 , 6 , 17 , 10.0 )");
			
			//2.27 is Birthday
			stmt.executeUpdate("insert into is_bday values(1 , 4 , 7)");
			stmt.executeUpdate("insert into is_bday values(2 , 4 , 8)");
			
			//2.29 Attending
			stmt.executeUpdate("insert into attending values(4 , 7 , 18 )");
			stmt.executeUpdate("insert into attending values(4 , 8 , 16 )");
			
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
			/*
			String storedProcedureuser = "CREATE PROCEDURE getuser7 ()" +
			"BEGIN " +
			" SELECT * FROM user; " + 
			"END";

			CallableStatement cstmt = connection.prepareCall("{call getuser7()}");
			cstmt.execute(storedProcedureuser);
			ResultSet resultSet = cstmt.executeQuery();
			
			while (resultSet.next()) 
            {
            	System.out.println("------------------");
            	System.out.print("USER  ");
            	System.out.println("NAME: " + resultSet.getString("name"));
            	System.out.println("------------------");
            	System.out.println("ID	:           " + resultSet.getString("user_id"));
            	System.out.println("BDATE	:        " + resultSet.getString("date_of_birth"));
            	System.out.println("EMAIL	:       " + resultSet.getString("email"));
            	System.out.println("GENDER	:         " + resultSet.getString("gender"));
            	System.out.println("PHONE   :         " + resultSet.getString("phone_number"));
            	System.out.println("PASSWORD:          " + resultSet.getString("password"));
            }
			
			cstmt.execute("DROP PROCEDURE getuser7");
			
			*/
			//stmt.execute("CREATE INDEX test ON user (gender)");
			
			/*
			String storedProcedurevisitor = "CREATE PROCEDURE getvisitor ()" +
			"BEGIN " +
			" SELECT * FROM visitor; " + 
			"END";

			CallableStatement cstmt = connection.prepareCall("{call getvisitor()}");
			cstmt.execute(storedProcedurevisitor);
			ResultSet resultSet = cstmt.executeQuery();
			
			while (resultSet.next()) 
            {
            	System.out.println("------------------");
            	System.out.print("VISITOR  ");
            	System.out.println("ID: " + resultSet.getString("user_id"));
            	System.out.println("------------------");
            	System.out.println("MONEY	:       " + resultSet.getString("money"));
            	System.out.println("DISCOUNT	:       " + resultSet.getString("discount_type"));
            }
			
			cstmt.execute("DROP PROCEDURE getvisitor");
			*/
			/*
			String storedProcedureemployee = "select * from employee";
			ResultSet resultSet = stmt.executeQuery(storedProcedureemployee);
			
			while (resultSet.next()) 
            {
            	System.out.println("------------------");
            	System.out.print("EMPLOYEE  ");
            	System.out.println("ID: " + resultSet.getString("user_id"));
            	System.out.println("------------------");
            	System.out.println("SSN	:       " + resultSet.getString("ssn"));
            	System.out.println("ADDRESS	:       " + resultSet.getString("address"));
				System.out.println("SALARY	:       " + resultSet.getString("salary"));
				System.out.println("YEARS	:       " + resultSet.getString("years_worked"));
				System.out.println("LEAVE	:       " + resultSet.getString("leave_days"));
				System.out.println("SHIFT	:       " + resultSet.getString("shift_hours"));
				System.out.println("BANKDETAILS:       " + resultSet.getString("bank_details"));
				System.out.println("CREATED By Coordinator	:       " + resultSet.getString("createdBy"));
            }
			*/
			/*
			String storedProcedurekeeper = "select * from keeper";
			ResultSet resultSet = stmt.executeQuery(storedProcedurekeeper);
			
			while (resultSet.next()) 
            {
            	System.out.println("------------------");
            	System.out.print("KEEPER  ");
            	System.out.println("ID: " + resultSet.getString("user_id"));
            	System.out.println("------------------");
            	System.out.println("SPECIALITY:       " + resultSet.getString("speciality"));
            }
			*/
			/*
			String storedProcedureveterinarian = "select * from veterinarian";
			ResultSet resultSet = stmt.executeQuery(storedProcedureveterinarian);
			
			while (resultSet.next()) 
            {
            	System.out.println("------------------");
            	System.out.print("VETERINARIAN  ");
            	System.out.println("ID: " + resultSet.getString("user_id"));
            	System.out.println("------------------");
            	System.out.println("certificate:       " + resultSet.getString("certificate"));
				System.out.println("branch:       " + resultSet.getString("branch"));
            }
			*/
			/*
			String storedProceduretreatment_request = "select * from treatment_request";
			ResultSet resultSet = stmt.executeQuery(storedProceduretreatment_request);
			
			while (resultSet.next()) 
            {
            	System.out.println("------------------");
            	System.out.print("treatment_request  ");
            	System.out.println("ID: " + resultSet.getString("request_id"));
            	System.out.println("------------------");
            	System.out.println("vet_id:       " + resultSet.getString("vet_id"));
				System.out.println("request_date:       " + resultSet.getString("request_date"));
				System.out.println("findings:       " + resultSet.getString("findings"));
				System.out.println("isAccepted:       " + resultSet.getString("isAccepted"));
				
            }
			*/
			/*
			String storedProcedurecoordinator = "select * from coordinator";
			ResultSet resultSet = stmt.executeQuery(storedProcedurecoordinator);
			
			while (resultSet.next()) 
            {
            	System.out.println("------------------");
            	System.out.print("COORDINATOR  ");
            	System.out.println("ID: " + resultSet.getString("user_id"));
            	System.out.println("------------------");
            	System.out.println("rank:       " + resultSet.getString("rank"));
				System.out.println("area_managed:       " + resultSet.getString("area_managed"));
            }
			*/
			/*
			String storedProcedureevent = "select * from event";
			ResultSet resultSet = stmt.executeQuery(storedProcedureevent);
			
			while (resultSet.next()) 
            {
            	System.out.println("------------------");
            	System.out.print("EVENT  ");
            	System.out.println("ID: " + resultSet.getString("event_id"));
            	System.out.println("------------------");
            	System.out.println("user_id:       " + resultSet.getString("user_id"));
				System.out.println("start_date:       " + resultSet.getString("start_date"));
				System.out.println("duration:       " + resultSet.getString("duration"));
            }
			*/
			/*
			String storedProcedureguide = "select * from guide";
			ResultSet resultSet = stmt.executeQuery(storedProcedureguide);
			
			while (resultSet.next()) 
            {
            	System.out.println("------------------");
            	System.out.print("GUIDE  ");
            	System.out.println("ID: " + resultSet.getString("user_id"));
            	System.out.println("------------------");
            	System.out.println("certificate:       " + resultSet.getString("certificate"));
				System.out.println("daily_tour_number:       " + resultSet.getString("daily_tour_number"));
            }
			*/

			/*
			String storedProcedureeducational_program = "select * from educational_program";
			ResultSet resultSet = stmt.executeQuery(storedProcedureeducational_program);
			
			while (resultSet.next()) 
            {
            	System.out.println("------------------");
            	System.out.print("EDUCATIONAL PROGRAM  ");
            	System.out.println("ID: " + resultSet.getString("event_id"));
            	System.out.println("------------------");
            	System.out.println("event_id:       " + resultSet.getString("user_id"));
				System.out.println("place:       " + resultSet.getString("place"));
				System.out.println("topic:       " + resultSet.getString("topic"));
            }
			*/
			/*
			String storedProcedureconservation_organization = "select * from conservation_organization";
			ResultSet resultSet = stmt.executeQuery(storedProcedureconservation_organization);
			
			while (resultSet.next()) 
            {
            	System.out.println("------------------");
            	System.out.print("conservation_organization  ");
            	System.out.println("ID: " + resultSet.getString("event_id"));
            	System.out.println("------------------");
            	System.out.println("user_id:       " + resultSet.getString("user_id"));
				System.out.println("fundings:       " + resultSet.getString("fundings"));
				System.out.println("participant_count:       " + resultSet.getString("participant_count"));
				System.out.println("name:       " + resultSet.getString("name"));
            }
			*/
			/*
			String storedProceduregroup_tour = "select * from group_tour";
			ResultSet resultSet = stmt.executeQuery(storedProceduregroup_tour);
			
			while (resultSet.next()) 
            {
            	System.out.println("------------------");
            	System.out.print("group_tour  ");
            	System.out.println("ID: " + resultSet.getString("event_id"));
            	System.out.println("------------------");
            	System.out.println("user_id:       " + resultSet.getString("user_id"));
				System.out.println("guide_id:       " + resultSet.getString("guide_id"));
				System.out.println("participant_count:       " + resultSet.getString("participant_count"));
				System.out.println("capacity:       " + resultSet.getString("capacity"));
            }
			*/
			/*
			String storedProcedureendangered_animal_birthday = "select * from endangered_animal_birthday";
			ResultSet resultSet = stmt.executeQuery(storedProcedureendangered_animal_birthday);
			
			while (resultSet.next()) 
            {
            	System.out.println("------------------");
            	System.out.print("endangered_animal_birthday  ");
            	System.out.println("ID: " + resultSet.getString("event_id"));
            	System.out.println("------------------");
            	System.out.println("user_id:       " + resultSet.getString("user_id"));
				System.out.println("party_type:       " + resultSet.getString("party_type"));
				System.out.println("number_of_birthday_animals:       " + resultSet.getString("number_of_birthday_animals"));
            }
			*/
			/*
			String storedProceduretreatment = "select * from treatment";
			ResultSet resultSet = stmt.executeQuery(storedProceduretreatment);
			
			while (resultSet.next()) 
            {
            	System.out.println("------------------");
            	System.out.print("treatment  ");
            	System.out.println("ID: " + resultSet.getString("treatment_id"));
            	System.out.println("------------------");
            	System.out.println("medicine:       " + resultSet.getString("medicine"));
				System.out.println("recommended_diet:       " + resultSet.getString("recommended_diet"));
				System.out.println("treatment_duration:       " + resultSet.getString("treatment_duration"));
            }
			*/
			/*
			String storedProcedurecage = "select * from cage";
			ResultSet resultSet = stmt.executeQuery(storedProcedurecage);
			
			while (resultSet.next()) 
            {
            	System.out.println("------------------");
            	System.out.print("cage  ");
            	System.out.println("ID: " + resultSet.getString("cage_id"));
            	System.out.println("------------------");
            	System.out.println("animal_count:       " + resultSet.getString("animal_count"));
				System.out.println("cage_type:       " + resultSet.getString("cage_type"));
				System.out.println("last_care_date:       " + resultSet.getString("last_care_date"));
				System.out.println("feed_time:       " + resultSet.getString("feed_time"));
				System.out.println("location:       " + resultSet.getString("location"));
            }
			*/
			/*
			String storedProcedurefood = "select * from food";
			ResultSet resultSet = stmt.executeQuery(storedProcedurefood);
			
			while (resultSet.next()) 
            {
            	System.out.println("------------------");
            	System.out.print("food  ");
            	System.out.println("ID: " + resultSet.getString("barcode"));
            	System.out.println("------------------");
            	System.out.println("type:       " + resultSet.getString("type"));
				System.out.println("calories:       " + resultSet.getString("calories"));
				System.out.println("stock:       " + resultSet.getString("stock"));
				System.out.println("name:       " + resultSet.getString("name"));
            }
			*/
			/*
			String storedProcedurecomment = "select * from comment";
			ResultSet resultSet = stmt.executeQuery(storedProcedurecomment);
			
			while (resultSet.next()) 
            {
            	System.out.println("------------------");
            	System.out.print("comment  ");
            	System.out.println("ID: " + resultSet.getString("comment_id"));
            	System.out.println("------------------");
            	System.out.println("comment_text:       " + resultSet.getString("comment_text"));
				System.out.println("date:       " + resultSet.getString("date"));
				System.out.println("anonymity:       " + resultSet.getString("anonymity"));
				System.out.println("star_rate:       " + resultSet.getString("star_rate"));
				System.out.println("user_id:       " + resultSet.getString("user_id"));
				System.out.println("visitor id:       " + resultSet.getString("vis_id"));
				System.out.println("event_id:       " + resultSet.getString("event_id"));
            }
			*/
			/*
			String storedProcedurecomplaint = "select * from complaint";
			ResultSet resultSet = stmt.executeQuery(storedProcedurecomplaint);
			
			while (resultSet.next()) 
            {
            	System.out.println("------------------");
            	System.out.print("form  ");
            	System.out.println("ID: " + resultSet.getString("form_id"));
            	System.out.println("------------------");
            	System.out.println("form_text:       " + resultSet.getString("form_text"));
				System.out.println("date:       " + resultSet.getString("date"));
				System.out.println("about:       " + resultSet.getString("about"));
				System.out.println("coor_id:       " + resultSet.getString("coor_id"));
				System.out.println("vis_id:       " + resultSet.getString("vis_id"));
				System.out.println("respond_text:       " + resultSet.getString("respond_text"));
            }
			*/
			/*
			String storedProcedureanimal = "select * from animal";
			ResultSet resultSet = stmt.executeQuery(storedProcedureanimal);
			
			while (resultSet.next()) 
            {
            	System.out.println("------------------");
            	System.out.print("animal  ");
            	System.out.println("ID: " + resultSet.getString("animal_id"));
            	System.out.println("------------------");
            	System.out.println("trainer_id:       " + resultSet.getString("trainer_id"));
				System.out.println("cage_id:       " + resultSet.getString("cage_id"));
				System.out.println("species:       " + resultSet.getString("species"));
				System.out.println("date_of_birth:       " + resultSet.getString("date_of_birth"));
				System.out.println("last_health_check:       " + resultSet.getString("last_health_check"));
				System.out.println("name:       " + resultSet.getString("name"));
				System.out.println("gender:       " + resultSet.getString("gender"));
				System.out.println("weight:       " + resultSet.getString("weight"));
				System.out.println("origin:       " + resultSet.getString("origin"));
				System.out.println("diet:       " + resultSet.getString("diet"));
				System.out.println("isEndangered:       " + resultSet.getString("isEndangered"));
				System.out.println("habitat:       " + resultSet.getString("habitat"));
				System.out.println("height:       " + resultSet.getString("height"));
				System.out.println("status:       " + resultSet.getString("status"));
            }
			*/
			/*
			stmt.execute("DROP PROCEDURE IF EXISTS gettraining");
			
			String storedProceduretrainer = "CREATE PROCEDURE gettraining ()" +
			"BEGIN " +
			" SELECT * FROM training; " + 
			"END";
			
			CallableStatement cstmt = connection.prepareCall("{call gettraining()}");
			
			cstmt.execute(storedProceduretrainer);

			//ResultSet resultSet = cstmt.executeQuery("SELECT * FROM training WHERE training_date >= curdate()");
			ResultSet resultSet = cstmt.executeQuery("SELECT * FROM training");

			while(resultSet.next())
			{
					stmt.executeUpdate("delete from training where training_date < curdate()");
			}
			resultSet = cstmt.executeQuery("SELECT * FROM training");
			while (resultSet.next())
            {
				System.out.println("------------------");
				System.out.print("training2  ");
				System.out.println("ID: " + resultSet.getString("training_id"));
				System.out.println("------------------");
				System.out.println("animal_id:       " + resultSet.getString("animal_id"));
				System.out.println("trainer_id:       " + resultSet.getString("trainer_id"));
				System.out.println("training_date:       " + resultSet.getString("training_date"));
				System.out.println("training_topic:       " + resultSet.getString("training_topic"));
		   }
			
			cstmt.execute("DROP PROCEDURE IF EXISTS gettraining");
			*/
			
			/*
			String storedProceduredonation = "select * from donation";
			ResultSet resultSet = stmt.executeQuery(storedProceduredonation);
			
			while (resultSet.next()) 
            {
            	System.out.println("------------------");
            	System.out.print("user  ");
            	System.out.println("ID: " + resultSet.getString("user_id"));
            	System.out.println("------------------");
            	System.out.println("event_id:       " + resultSet.getString("event_id"));
				System.out.println("coor_id:       " + resultSet.getString("coor_id"));
				System.out.println("amount:       " + resultSet.getString("amount"));
            }
			*/
			/*
			String storedProcedureregularize_food = "select * from regularize_food";
			ResultSet resultSet = stmt.executeQuery(storedProcedureregularize_food);
			
			while (resultSet.next()) 
            {
            	System.out.println("------------------");
            	System.out.print("cage  ");
            	System.out.println("ID: " + resultSet.getString("cage_id"));
            	System.out.println("------------------");
            	System.out.println("barcode:       " + resultSet.getString("barcode"));
				System.out.println("feed_time:       " + resultSet.getString("feed_time"));
				System.out.println("amount:       " + resultSet.getString("amount"));
				System.out.println("user_id:       " + resultSet.getString("user_id"));
            }
			*/
			/*
			String storedProcedurerequest = "select * from request";
			ResultSet resultSet = stmt.executeQuery(storedProcedurerequest);
			
			while (resultSet.next()) 
            {
            	System.out.println("------------------");
            	System.out.print("request  ");
            	System.out.println("ID: " + resultSet.getString("request_id"));
            	System.out.println("------------------");
            	System.out.println("animal_id:       " + resultSet.getString("animal_id"));
				System.out.println("user_id:       " + resultSet.getString("user_id"));
            }
			*/
			/*
			String storedProcedureassigned = "select * from assigned";
			ResultSet resultSet = stmt.executeQuery(storedProcedureassigned);
			
			while (resultSet.next()) 
            {
            	System.out.println("------------------");
            	System.out.print("cage  ");
            	System.out.println("ID: " + resultSet.getString("cage_id"));
            	System.out.println("------------------");
            	System.out.println("keep_id:       " + resultSet.getString("keep_id"));
				System.out.println("coor_id:       " + resultSet.getString("coor_id"));
            }
			*/
			/*
			String storedProcedureinvitation = "select * from invitation";
			ResultSet resultSet = stmt.executeQuery(storedProcedureinvitation);
			
			while (resultSet.next()) 
            {
            	System.out.println("------------------");
            	System.out.print("invitation vet  ");
            	System.out.println("ID: " + resultSet.getString("vet_id"));
            	System.out.println("------------------");
            	System.out.println("coor_id:       " + resultSet.getString("coor_id"));
				System.out.println("event_id:       " + resultSet.getString("event_id"));
				System.out.println("isAccepted:       " + resultSet.getString("isAccepted"));
            }
			*/
			/*
			String storedProceduregive = "select * from give";
			ResultSet resultSet = stmt.executeQuery(storedProceduregive);
			
			while (resultSet.next()) 
            {
            	System.out.println("------------------");
            	System.out.print("request  ");
            	System.out.println("ID: " + resultSet.getString("request_id"));
            	System.out.println("------------------");
            	System.out.println("animal_id:       " + resultSet.getString("animal_id"));
				System.out.println("treatment_id:       " + resultSet.getString("treatment_id"));
            }
			*/
			/*
			String storedProcedurepay = "select * from pay";
			ResultSet resultSet = stmt.executeQuery(storedProcedurepay);
			
			while (resultSet.next()) 
            {
            	System.out.println("------------------");
            	System.out.print("pay user  ");
            	System.out.println("ID: " + resultSet.getString("user_id"));
            	System.out.println("------------------");
            	System.out.println("coor_id:       " + resultSet.getString("coor_id"));
				System.out.println("event_id:       " + resultSet.getString("event_id"));
				System.out.println("requested_amount:       " + resultSet.getString("requested_amount"));
            }
			*/
			/*
			String storedProcedureis_bday = "select * from is_bday";
			ResultSet resultSet = stmt.executeQuery(storedProcedureis_bday);
			
			while (resultSet.next()) 
            {
            	System.out.println("------------------");
            	System.out.print("animal ");
            	System.out.println("ID: " + resultSet.getString("animal_id"));
            	System.out.println("------------------");
            	System.out.println("coor_id:       " + resultSet.getString("coor_id"));
				System.out.println("event_id:       " + resultSet.getString("event_id"));
            }
			*/
			/*
			String storedProcedureattending = "select * from attending";
			ResultSet resultSet = stmt.executeQuery(storedProcedureattending);
			
			while (resultSet.next()) 
            {
            	System.out.println("------------------");
            	System.out.print("attending user  ");
            	System.out.println("ID: " + resultSet.getString("user_id"));
            	System.out.println("------------------");
            	System.out.println("coor_id:       " + resultSet.getString("coor_id"));
				System.out.println("event_id:       " + resultSet.getString("event_id"));
            }
			
			
			
			*/
			System.out.println("All done");
			
			} catch(SQLException e) {
            System.out.println("An Error Occured in Database");
            e.printStackTrace();
			
			
        }
	}
}