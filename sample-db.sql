create table products (
    product_id int not null,
    provider_name varchar(200) not null,
    provider_domain varchar(200) not null,
    product_name varchar(200) not null,
    product_variation varchar(200) default null,
    monthly_price decimal(8, 2) not null default 0.00,
    primary key(product_id)
)

insert into products(product_id, provider_name, provider_domain, product_name, product_variation, monthly_price)
values
(1, "BSNL", "broadband", "100MB", NULL, 30),
(2, "BSNL", "broadband", "200MB", NULL, 40),
(3, "BSNL", "broadband", "300MB", NULL, 50),
(4, "Airtel", "broadband", "17MB", NULL, 25),
(5, "Airtel", "broadband", "72MB", NULL, 40),

(6, "Indane energy", "energy", "Standard tariff", "North", 54.12),
(7, "Indane energy", "energy", "Standard tariff", "Mid", 56.50),
(8, "Indane energy", "energy", "Standard tariff", "South", 61.92),
(9, "Indane energy", "energy", "Green tariff", "North", 64.85),
(10, "Indane energy", "energy", "Green tariff", "Mid", 68.21),
(11, "Indane energy", "energy", "Green tariff", "South", 71.66),

(12, "Tata Power", "energy", "Standard tariff", "North", 51.95),
(13, "Tata Power", "energy", "Standard tariff", "Mid", 52.00),
(14, "Tata Power", "energy", "Standard tariff", "South", 56.62),
(15, "Tata Power", "energy", "Saver tariff", "North", 42.57),
(16, "Tata Power", "energy", "Saver tariff", "Mid", 45.22),
(17, "Tata Power", "energy", "Saver tariff", "South", 47.67)
