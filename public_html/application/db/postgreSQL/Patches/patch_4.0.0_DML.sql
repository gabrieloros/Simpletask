-- ADR
-- nuevo modulo
INSERT into module(id,modulename) values(3,'adr');
INSERT INTO menu(id, menukey, parentid, menulevel, menuorder, moduleid, visible) VALUES(13, 'ADR', null, 0, 100, 3, 't');
INSERT INTO urlmapping(url, menuid, languageid) VALUES('adr', 13, 1);
INSERT INTO menu_translation(menuid, languageid, title) VALUES(13 , 1, 'Atención de reclamos');
INSERT INTO usertypeaccess(usertypeid, menuid) VALUES(1, 13);

-- sub menu usuario
INSERT INTO menu(id, menukey, parentid, menulevel, menuorder, moduleid, visible) VALUES(14, 'adr?action=getListUser', 13, 1, 1, 3, 't');
INSERT INTO urlmapping(url, menuid, languageid) VALUES('adr?action=getListUser', 14, 1);
INSERT INTO menu_translation(menuid, languageid, title) VALUES(14 , 1, 'Gestión de usuarios');
INSERT INTO usertypeaccess(usertypeid, menuid) VALUES(1, 14);

UPDATE MENU SET menukey='adr_list_users' WHERE id =14;
UPDATE MENU SET menukey='adr' WHERE id =13;


-- submenu empresas
INSERT INTO menu(id, menukey, parentid, menulevel, menuorder, moduleid, visible)VALUES(15, 'adr_list_plans', 13, 1, 2, 3, 't');
INSERT INTO urlmapping(url, menuid, languageid) VALUES('adr?action=getListPLan', 15, 1);
INSERT INTO menu_translation(menuid, languageid, title) VALUES(15 , 1, 'Gestión de empresas');
INSERT INTO usertypeaccess(usertypeid, menuid) VALUES(1, 15);


-- Tipos de usuario
INSERT INTO usertype(id, typename) VALUES(4, 'Reclamos ADR');


-- Estados de los usuarios adr
INSERT INTO systemuseradrstate(description) VALUES('Conectado');
INSERT INTO systemuseradrstate(description) VALUES('Desconectado');
INSERT INTO systemuseradrstate(description) VALUES('Sin Conexión');


-- Submenú seguimiento de reclamos
INSERT INTO menu(id, menukey, parentid, menulevel, menuorder, moduleid, visible) VALUES(17, 'adr_claim_track', 13 , 1 , 3 , 3 , 't' );
INSERT INTO menu_translation(menuid, languageid, title) VALUES(17, 1, 'Seguimiento de Reclamos');
INSERT INTO urlmapping(url, menuid, languageid) VALUES('adr?action=getClaimsTrack', 17, 1);
INSERT INTO menu_translation(menuid, languageid, title) VALUES(17 , 1, 'Seguimiento de Reclamos');


-- Submenú historial de usuarios
INSERT INTO menu(id, menukey, parentid, menulevel, menuorder, moduleid, visible) VALUES(19, 'adr_user_history', 13, 1, 4, 3, 't');
INSERT INTO urlmapping(url, menuid, languageid) VALUES('adr?action=getAdrUserHistory', 19, 1);
INSERT INTO menu_translation(menuid, languageid, title) VALUES(19, 1, 'Historial de usuarios');
INSERT INTO usertypeaccess(usertypeid, menuid) VALUES(1, 19);


-- Submenú asignación de tareas
INSERT INTO menu(id, menukey, parentid, menulevel, menuorder, moduleid, visible) VALUES(18, 'adr_assign_tasks', 13, 1, 5, 3, 't');
INSERT INTO urlmapping(url, menuid, languageid) VALUES('adr?action=getAssignTasks', 18, 1);
INSERT INTO menu_translation(menuid, languageid, title) VALUES(18, 1, 'Asignación de tareas');
INSERT INTO usertypeaccess(usertypeid, menuid) VALUES(1, 18);

-- LDR
INSERT INTO usertype(id, typename) VALUES(4, 'Reclamos LDR - Web Teléfono');

-- Menú
INSERT into module(id,modulename) values(4,'ldr');
INSERT INTO menu(id, menukey, parentid, menulevel, menuorder, moduleid, visible)VALUES(16, 'LDR', null, 0, 1, 4, 't');
INSERT INTO urlmapping(url, menuid, languageid) VALUES('ldr', 16, 1);
INSERT INTO menu_translation(menuid, languageid, title) VALUES(16 , 1, 'Mapa / Reclamos'); 

-- asociación menu con tipo de usuario (visibilidad)
INSERT INTO usertypeaccess(usertypeid, menuid) VALUES(4, 16);


-- Parametros de sesion
INSERT INTO parameters(id, paramname, paramvalue) VALUES(5, 'adr_track_default_days', 30);
INSERT INTO parameters(id, paramname, paramvalue) VALUES(6, 'adr_track_interval_time', 5000);
INSERT INTO parameters(id, paramname, paramvalue) VALUES(7, 'lbs_urlportal', 'http://www-dev.gdr-reclamos.com')
INSERT INTO parameters(id, paramname, paramvalue) VALUES(8, 'lbs_claimRadius', '50');


-- subestados de reclamos asignados substateldr 
INSERT INTO substateldr (id, description) VALUES (0, 'Pendiente');
INSERT INTO substateldr (id, description) VALUES (1, 'El usuario llegó al reclamo');
INSERT INTO substateldr (id, description) VALUES (2, 'Dar de baja reclamo, pasado el 1° tiempo');
INSERT INTO substateldr (id, description) VALUES (2, 'Cerrar Reclamo pasado el tiempo especificado en el plan');


-- motivos por los cual no se puedo arreglar un reclamo
INSERT INTO withoutfixingldr (name,description) VALUES ('Otro','Otro motivo no cargado');
INSERT INTO withoutfixingldr (name,description) VALUES ('Problema con el poste','Problema con el poste');
INSERT INTO withoutfixingldr (name,description) VALUES ('Vehículo obstruye','Vehículo obstruye');
INSERT INTO withoutfixingldr (name,description) VALUES ('Falta de materiales','Falta de materiales');
INSERT INTO withoutfixingldr (name,description) VALUES ('Zona peligrosa','Zona peligrosa');
INSERT INTO withoutfixingldr (name,description) VALUES ('Fuera de zona','Fuera de zona');
INSERT INTO withoutfixingldr (name,description) VALUES ('Sin acceso','Sin acceso');
INSERT INTO withoutfixingldr (name,description) VALUES ('De la cooperativa','De la cooperativa');
INSERT INTO withoutfixingldr (name,description) VALUES ('Reclamos de forestación','Reclamos de forestación');


-- materiales 
INSERT INTO materialldr (name,description) VALUES ('Otro','Foco');


-- Estados de reclamos
INSERT INTO state (id, name) VALUES (1, 'pending');
INSERT INTO state (id, name) VALUES (2, 'closed');
INSERT INTO state (id, name) VALUES (3, 'cancelled');
INSERT INTO state (id, name) VALUES (4, 'closed_no_geo');


-- Zonas
INSERT INTO zone (id, name, locationid, coordinates, "position") VALUES (2, 'Villa Hipódromo', 1, '-32.91167936970072,-68.8504686334636;-32.91333663404906,-68.85094070225023;-32.91481373481722,-68.85049009113573;-32.92164050226504,-68.85186338215135;-32.92092002395993,-68.85632657795213;-32.922775243700684,-68.86087560444139;-32.92473781330476,-68.86469480388769;-32.92277456485572,-68.86336375766405;-32.90868889388287,-68.86422206454881;-32.90294320148012,-68.86587430530199;-32.90276135543236,-68.8647149204553;-32.90222144499751,-68.86402894549974;-32.90204860705305,-68.86035632982384;-32.90186844815967,-68.85695528879296;-32.90232785261349,-68.85350060358178;-32.90233326263565,-68.85197925148532;-32.91167936970072,-68.8504686334636', 'position: absolute; top: 78px; right: 607px; bottom: 146px; left: 432px; width: 174px; height: 72px; padding: 5px;');
INSERT INTO zone (id, name, locationid, coordinates, "position") VALUES (5, 'Las Tortugas', 1, '-32.95852115133862,-68.85270024184138;-32.95414598019517,-68.84986782912165;-32.950472829772345,-68.84619856718928;-32.94801317235687,-68.84382319869474;-32.93886538978278,-68.84116244735196;-32.93828911982477,-68.84072256507352;-32.94026283059494,-68.8325514877215;-32.94044291134097,-68.83072758559138;-32.944048054229526,-68.81507207639515;-32.949414073357616,-68.81824781186879;-32.96104533201425,-68.82610131986439;-32.95992908567264,-68.84335328824818;-32.95852115133862,-68.85270024184138', 'position: absolute; top: 463px; right: 743px; bottom: 532px; left: 567px; width: 174px; height: 72px; padding: 5px;');
INSERT INTO zone (id, name, locationid, coordinates, "position") VALUES (6, 'Benegas', 1, '-32.95863636870661,-68.86227679147851;-32.956340784219805,-68.85816764726769;-32.95061416983135,-68.85503804631298;-32.94754499294877,-68.85348987474572;-32.94106553241864,-68.84997832748923;-32.93698574320646,-68.85049116604932;-32.937598601705844,-68.84726849191793;-32.93830037293504,-68.8407339602054;-32.93886482482268,-68.84116445475229;-32.948012607455226,-68.84382453554281;-32.95414822645746,-68.84987318502681;-32.95852047221856,-68.85270197682985;-32.95863636870661,-68.86227679147851', 'position: absolute; top: 364px; right: 688px; bottom: 433px; left: 512px; width: 174px; height: 72px; padding: 5px;');
INSERT INTO zone (id, name, locationid, coordinates, "position") VALUES (7, 'Trapiche', 1, '-32.94807619513502,-68.90082549944054;-32.943883730668524,-68.87591528866324;-32.938408424374025,-68.86317265059915;-32.93703470505948,-68.85048714306322;-32.94106519663846,-68.8499802055594;-32.947613200210824,-68.85352769546444;-32.950193620178396,-68.85482829835382;-32.95366140876046,-68.856705174112;-32.956338540760534,-68.85816831912962;-32.95863637584945,-68.86227813389269;-32.95904327663731,-68.86757040861994;-32.96045482454672,-68.89876554720104;-32.94807619513502,-68.90082549944054', 'position: absolute; top: 421px; right: 467px; bottom: 490px; left: 291px; width: 174px; height: 72px; padding: 5px;');
INSERT INTO zone (id, name, locationid, coordinates, "position") VALUES (8, 'Villa Marini', 1, '-32.9340029853963,-68.9009435166372;-32.93334846161584,-68.89323216670164;-32.92677418670931,-68.87576696302858;-32.92474208910859,-68.86469560966361;-32.9209215960549,-68.8563269826409;-32.92164263721859,-68.85186177518335;-32.926127482646656,-68.85263760414091;-32.9340328200016,-68.8511134388682;-32.93392476376639,-68.85017131295172;-32.93583148669604,-68.85064271118608;-32.93703357951257,-68.85048647251097;-32.93746882820025,-68.8540509933955;-32.93840797756963,-68.86317157535814;-32.94064099973802,-68.8682785013225;-32.94388238319428,-68.8759174325969;-32.94806721826047,-68.90082548372447;-32.9340029853963,-68.9009435166372', 'position: absolute; top: 290px; right: 467px; bottom: 359px; left: 326px; width: 174px; height: 72px; padding: 5px;');
INSERT INTO zone (id, name, locationid, coordinates, "position") VALUES (3, 'Centro', 1, '-32.93829992667967,-68.8407268607989;-32.937597592677065,-68.84727145079523;-32.936985296944464,-68.8504901016131;-32.93583272877151,-68.85064030531794;-32.93392375469569,-68.85016823653132;-32.93403181093215,-68.85111237410456;-32.92612534780132,-68.85263586882502;-32.92164185007815,-68.85185855731834;-32.914812492996376,-68.85048982527223;-32.91333663075068,-68.85093936376506;-32.911679253705394,-68.85046836760012;-32.90300513038948,-68.8518698218104;-32.90413482562065,-68.83704473264515;-32.9117730455095,-68.83781720884144;-32.913934686213715,-68.83670140989125;-32.91861805998381,-68.83678724057972;-32.92351732422432,-68.83640100248158;-32.93829992667967,-68.8407268607989', 'position: absolute; top: 172px; right: 701px; bottom: 241px; left: 525px; width: 174px; height: 72px; padding: 5px;');
INSERT INTO zone (id, name, locationid, coordinates, "position") VALUES (4, 'San Francisco del Monte', 1, '-32.94404804763504,-68.81506937847007;-32.93637660226705,-68.8108663726598;-32.936952884687216,-68.80790521390736;-32.93007326816421,-68.80460073240101;-32.92708352980896,-68.81713201291859;-32.92463403031932,-68.82687379606068;-32.92351697958284,-68.83640085186926;-32.938287992095525,-68.8407232314512;-32.94026158858169,-68.83254919939645;-32.94404804763504,-68.81506937847007', 'position: absolute; top: 266px; right: 861px; bottom: 335px; left: 685px; width: 174px; height: 72px; padding: 5px;');
INSERT INTO zone (id, name, locationid, coordinates, "position") VALUES (-1, 'No Region', 1, '0,0;0,0;0,0;0,0', NULL);
INSERT INTO zone (id, name, locationid, coordinates, "position") VALUES (1, 'Villa del parque', 1, '-32.89968128732296,-68.90119457035325;-32.89769946636552,-68.8902511575725;-32.896780607057565,-68.88074540882371;-32.89960922188329,-68.87621784262592;-32.900618132702725,-68.86847162299091;-32.90153695219918,-68.86493110709125;-32.902221556606854,-68.86402988486225;-32.90276203003245,-68.86471653037006;-32.902942187107975,-68.8658752446645;-32.90868900548406,-68.86422300391132;-32.92277523930332,-68.86336469702655;-32.92473848773738,-68.86469507269794;-32.92677373599861,-68.87576723151142;-32.92897103112014,-68.88188266544603;-32.933347448141724,-68.89323377399705;-32.93399578780451,-68.90093707828782;-32.89968128732296,-68.90119457035325', 'position: absolute; top: 78px; right: 398px; bottom: 146px; left: 224px; width: 174px; height: 72px; padding: 5px;');

-- Input types
INSERT INTO inputtype(id, name) VALUES(4, 'manual');

-- Origin
INSERT INTO origin(id, name) VALUES(4, 'originmanual');