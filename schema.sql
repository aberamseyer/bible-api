CREATE TABLE books (
	id INTEGER NOT NULL,
	name VARCHAR NOT NULL,
	chapters INTEGER NOT NULL,
	testament INTEGER NOT NULL,
	abbreviations LONGTEXT NOT NULL,
	word_count INTEGER
);
CREATE TABLE chapters (
	id INTEGER NOT NULL,
	book_id INTEGER NOT NULL,
	"number" INTEGER NOT NULL,
	verses INTEGER NOT NULL,
	word_count INTEGER
);
CREATE TABLE verses (
	id INTEGER NOT NULL,
	chapter_id INTEGER NOT NULL,
	"number" INTEGER NOT NULL,
	rcv TEXT NOT NULL,
	kjv TEXT NOT NULL,
	niv TEXT NOT NULL,
	esv TEXT NOT NULL,
	nlt TEXT NOT NULL,
	orig TEXT NOT NULL,
	asv TEXT,
	word_count INTEGER
, reference TEXT DEFAULT ('abe') NOT NULL);
