DROP DATABASE IF EXISTS webAgoraforia;
CREATE DATABASE IF NOT EXISTS webAgoraforia;
USE webAgoraforia;

CREATE TABLE users(
	id bigint(20) NOT NULL AUTO_INCREMENT,
	nick varchar(20) NOT NULL,
	password char(32) NOT NULL,
	email varchar(20) NOT NULL,
	name varchar(20) NOT NULL,
	surname varchar(20) NOT NULL,
	date date NOT NULL,
	creation_date timestamp NOT NULL,
	creation_ip varchar(15) NOT NULL,
	active BOOLEAN NOT NULL,
	PRIMARY KEY (id)
)
ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

CREATE TABLE groups(
	id bigint(20) NOT NULL AUTO_INCREMENT,
	uid bigint(20),
	name varchar(20) NOT NULL,
	description varchar(100) NOT NULL,
	creation_date timestamp NOT NULL,
	creation_ip varchar(15) NOT NULL,
	active BOOLEAN NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (uid) REFERENCES users(id) ON DELETE SET NULL
)
ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

CREATE TABLE members(
	uid bigint(20) NOT NULL,
	gid bigint(20) NOT NULL,
	PRIMARY KEY (uid, gid),
	FOREIGN KEY (uid) REFERENCES users(id) ON DELETE CASCADE,
	FOREIGN KEY (gid) REFERENCES groups(id) ON DELETE CASCADE
)
ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

CREATE TABLE invitations(
	uid bigint(20) NOT NULL,
	gid bigint(20) NOT NULL,
	PRIMARY KEY (uid, gid),
	FOREIGN KEY (uid) REFERENCES users(id) ON DELETE CASCADE,
	FOREIGN KEY (gid) REFERENCES groups(id) ON DELETE CASCADE
)
ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

CREATE TABLE shared(
	uid bigint(20) NOT NULL,
	path varchar(255) NOT NULL,
	file varchar(255) NOT NULL,
	hash char(32) NOT NULL,
	PRIMARY KEY (uid, path, file),
	FOREIGN KEY (uid) REFERENCES users(id) ON DELETE CASCADE
)
ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

CREATE TABLE forums(
	id bigint(20) NOT NULL AUTO_INCREMENT,
	name varchar(20) NOT NULL,
	description varchar(100) NOT NULL,
	gid bigint(20),
	visible boolean NOT NULL,
	PRIMARY KEY (id)
)
ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

CREATE TABLE admins(
	uid bigint(20) NOT NULL,
	fid bigint(20) NOT NULL,
	PRIMARY KEY (uid, fid),
	FOREIGN KEY (uid) REFERENCES users(id) ON DELETE CASCADE,
	FOREIGN KEY (fid) REFERENCES forums(id) ON DELETE CASCADE
)
ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

CREATE TABLE posts(
	id bigint(20) NOT NULL AUTO_INCREMENT,
	uid bigint(20),
	fid bigint(20),
	title varchar(20) NOT NULL,
	content text NOT NULL,
	creation_date timestamp NOT NULL,
	creation_ip varchar(15) NOT NULL,
	visible boolean NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (uid) REFERENCES users(id) ON DELETE SET NULL,
	FOREIGN KEY (fid) REFERENCES forums(id) ON DELETE SET NULL
)
ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

CREATE TABLE comments(
	id bigint(20) NOT NULL AUTO_INCREMENT,
	uid bigint(20),
	pid bigint(20),
	title varchar(20) NOT NULL,
	content text NOT NULL,
	creation_date timestamp NOT NULL,
	creation_ip varchar(15) NOT NULL,
	visible boolean NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (uid) REFERENCES users(id) ON DELETE SET NULL,
	FOREIGN KEY (pid) REFERENCES posts(id) ON DELETE SET NULL
)
ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

CREATE TABLE messages(
	id bigint(20) NOT NULL AUTO_INCREMENT,
	sender_id bigint(20),
	reciver_id bigint(20),
	title varchar(20) NOT NULL,
	content text NOT NULL,
	creation_date timestamp NOT NULL,
	creation_ip varchar(15) NOT NULL,
	read_date timestamp NULL,
	visible boolean NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE SET NULL,
	FOREIGN KEY (reciver_id) REFERENCES users(id) ON DELETE SET NULL
)
ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
