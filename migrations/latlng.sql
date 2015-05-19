set names utf8;

ALTER TABLE places add lat varchar(30);
ALTER TABLE places add lng varchar(30);

update places set lat = "51.7550241", lng = "19.4603525" where name = "VIII Dom Studenta";
update places set lat = "51.7454392", lng = "19.4519672" where name = "Centrum Językowe PŁ";
update places set lat = "51.754692", lng = "19.452726" where name = "Wydział Biotechnologii i Nauk o Żywności PŁ";
update places set lat = "51.7752035", lng = "19.5045822" where name = "Centrum Dydaktyczne UMed";
update places set lat = "51.7681431", lng = "19.4369655" where name = "Plac Hallera";
update places set lat = "51.775397", lng = "19.492095" where name = "Biblioteka UMed";
update places set lat = "51.7489999", lng = "19.4495" where name = "Stołówka PŁ";
update places set lat = "51.7756558", lng = "19.4874598" where name = "Wydział Zarządzania UŁ";
update places set lat = "51.77757", lng = "19.482429" where name = "Wydział Prawa i Administracji UŁ";
update places set lat = "51.7624552", lng = "19.4545907" where name = "Wydział Filologiczny UŁ";
update places set lat = "51.7752181", lng = "19.4650954" where name = "Wydział Ekonomiczno-Socjologiczny UŁ";
update places set lat = "51.7806933", lng = "19.4929587" where name = "Centrum WFiS UŁ";
update places set lat = "51.738132", lng = "19.4668919" where name = "Wyższa Szkoła Informatyki i Umiejętności";
update places set lat = "51.743042", lng = "19.816316" where name = "Kino Odeon 3D";
update places set lat = "51.763543", lng = "19.458113" where name = "Pasaż Schillera";
update places set lat = "51.7517697", lng = "19.4482076" where name = "AHE w Łodzi";
update places set lat = "51.7532364", lng = "19.4538706" where name = "Wydział Elektrotechniki, Elektroniki, Informatyki i Automatyki PŁ";
update places set lat = "51.7728789", lng = "19.4485819" where name = "Akademia Muzyczna w Łodzi";


