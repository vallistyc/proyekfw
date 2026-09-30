CREATE TABLE dokter (
    iddokter SERIAL PRIMARY KEY,
    no_izin VARCHAR(45) NOT NULL,
    spesialisasi VARCHAR(100) NOT NULL,
    iduser BIGINT NOT NULL UNIQUE REFERENCES "user"(iduser) ON DELETE CASCADE
);