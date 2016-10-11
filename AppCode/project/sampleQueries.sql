use survey_db;

select * from tbl_admin;
select * from tbl_users;
select * from tbl_surveys;
select * from tbl_questions;
select * from tbl_survey_questions;

insert into tbl_admin values (null,'adminsri@test.com','admin','adminSrinivas','', null,'','','','',  '','','','', 'srinivasjinde@gmail.com');

insert into tbl_admin values (null, 'adminmo@test.com','admin','adminNassar','', null,'','','','',  '','','','', 'mnassar92@gmail.com');

insert into tbl_users values (null,'usersri@test.com','user','userSrinivas','', null,'','','','',  '','','','', 'srinivasjinde@gmail.com');

insert into tbl_users values (null, 'usermo@test.com','user','userNassar','', null,'','','','',  '','','','', 'mnassar92@gmail.com');

delete from tbl_admin where admin_name='adminsri@test.com';
delete from tbl_surveys where survey_name='survey1';

ALTER TABLE tbl_surveys ADD UNIQUE (survey_name);
ALTER TABLE tbl_questions ADD UNIQUE (question_content);

ALTER TABLE tbl_user_questions CHANGE survey_question_id user_question_id INT NOT NULL AUTO_INCREMENT;




