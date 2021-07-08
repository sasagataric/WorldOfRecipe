/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     23.6.2021. 01:56:13                          */
/*==============================================================*/



/*==============================================================*/
/* Table: Author                                                 */
/*==============================================================*/
create table Author
(
   Id                   int not null auto_increment,
   Name                  varchar(60) not null,
   Email                varchar(256) not null,
   Password                varchar(256) not null,
   Bio           text not null,
   Role                varchar(20) not null,
   Image                varchar(256) not null,
   primary key (Id)
);

/*==============================================================*/
/* Table: Category                                            */
/*==============================================================*/
create table Category
(
   Id                   int not null auto_increment,
   CategoryName     varchar(30) not null,
   primary key (Id)
);

/*==============================================================*/
/* Table: Recipe                                                */
/*==============================================================*/
create table Recipe
(
   Id                   int not null auto_increment,
   CategoryId        int not null,
   AuthorId            int not null,
   Title               varchar(100) not null,
   Content              text not null,
   Date                timestamp not null,
   Image                varchar(256) not null,
   primary key (Id)
);

alter table Recipe add constraint FK_Author foreign key (AuthorId)
      references Author (Id) on delete cascade on update cascade;

alter table Recipe add constraint FK_Category foreign key (CategoryId)
      references Category (Id) on delete restrict on update cascade;

