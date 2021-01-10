<?php

	//-----------Define All Page---------------------------------------------//
	DEFINE('PATH_INDEX_LOGOUT','index.php?page=true&logout=out');
	DEFINE('PATH_ASSCAT','index.php?asscat=true&page=asscat');
	DEFINE('PATH_FALCOD','index.php?falcod=true&page=falcod');
	DEFINE('PATH_DEPART','index.php?depart=true&page=depart');
	DEFINE('PATH_LOCATN','index.php?locatn=true&page=locatn');
	DEFINE('PATH_ASSTAT','index.php?asstat=true&page=asstat');
	DEFINE('PATH_CRITIC','index.php?critic=true&page=critic');
	DEFINE('PATH_WARRAN','index.php?warran=true&page=warran');
	DEFINE('PATH_WTRADE','index.php?wtrade=true&page=wtrade');
	DEFINE('PATH_PRIORY','index.php?priory=true&page=priory');
	DEFINE('PATH_WSTATE','index.php?wstate=true&page=wstate');
	DEFINE('PATH_WRTYPE','index.php?wrtype=true&page=wrtype');
	DEFINE('PATH_EMPLOY','index.php?employ=true&page=employ');
	DEFINE('PATH_SUPPLY','index.php?supply=true&page=supply');
	DEFINE('PATH_ASSETS','index.php?assets=true&page=assets');
	DEFINE('PATH_PMCHEK','index.php?pmchek=true&page=pmchek');
	DEFINE('PATH_POSITI','index.php?positi=true&page=positi');
	DEFINE('PATH_WORDER','index.php?worder=true&page=worder');
	DEFINE('PATH_PMSCHE','index.php?pmsche=true&page=pmsche');
	DEFINE('PATH_PMGENE','index.php?pmgene=true&page=pmgene');
	DEFINE('PATH_PMLIST','index.php?pmlist=true&page=pmlist');
	DEFINE('PATH_SCHEDU','index.php?schedu=true&page=schedu');
	DEFINE('PATH_ICHECK','index.php?icheck=true&page=icheck');
	DEFINE('PATH_LCHECK','index.php?lcheck=true&page=lcheck');
	DEFINE('PATH_FORMCK','index.php?formck=true&page=formck');
	DEFINE('PATH_DAILYC','index.php?dailyc=true&page=dailyc');
	DEFINE('PATH_AREA','index.php?area=true&page=area');
	DEFINE('PATH_PLANT','index.php?plant=true&page=plant');
	
	//----------- New Fitur -------------------------------------------------//
	DEFINE('PATH_EXPWO','index.php?expwo=true&page=expwo');
	DEFINE('PATH_EXPAS','index.php?expas=true&page=expas');
	
	//-----------Define add, delete, edit page-------------------------------//
	DEFINE('ADD','&add=ok');
	DEFINE('EDIT','&edit=ok');
	DEFINE('DELETE','&delete=ok');
	DEFINE('DETAIL','&detail=ok');
	DEFINE('CHILD','&child=ok');
	DEFINE('UPLOAD','&upload=ok');
	DEFINE('POST','&post=ok');
	DEFINE('GEN','&gen=ok');
	DEFINE('WO','&wo=ok');
	DEFINE('SPARE','&spare=ok');
	DEFINE('HISTORY','&history=ok');
	DEFINE('DOCUMENT','&doc=ok');
	DEFINE('STEPWORK','&stepwork=ok');
	DEFINE('PSPARE','&spare=ok');
	DEFINE('MANPOW','&power=ok');
	DEFINE('TEXP','&expense=ok');
	DEFINE('TPRINT','&print=ok');
	DEFINE('CHECKLIST','&checklist=ok');
	DEFINE('DELPSPARE','&delspare=ok&delete=ok');
	DEFINE('DELMANPOW','&delmanpow=ok&delete=ok');
	DEFINE('TREE','&tree=ok');
	
	//-----------Define Root DIrectory --------------------------------------//
	DEFINE('_ROOT_','page/Sisoft/');
	
	//-----------Define title of this page ----------------------------------//
	DEFINE('_TITLE_','Service And Maintenance');
	DEFINE('TSPARE','SPARE PART FOR ');
	
	//-----------Define title of for ----------------------------------//
	DEFINE('FASPAREP','Add Spare Part');
	
	//-----------Define SQL Languange ---------------------------------------//
	DEFINE('ASSCAT','SELECT AssetCategoryID Asset_Category_ID, AssetCatCode Asset_Category_Code, Assetcategory Asset_Category FROM asset_category');
	DEFINE('COUNTASSCAT','SELECT COUNT(*) FROM asset_category');
	DEFINE('FALCOD','SELECT FailureCauseID Failure_ID, FailureCauseCode Failure_Code, FailureCauseDesc Failure_Description FROM failure_cause');
	DEFINE('COUNTFALCOD','SELECT COUNT(*) FROM failure_cause');
	DEFINE('DEPART','SELECT DepartmentID Department_ID, DepartmentNo Department_No, DepartmentDesc Department_Desc FROM department');
	DEFINE('COUNTDEPART','SELECT COUNT(*) FROM department');
	DEFINE('LOCATN','SELECT L.LocationId Location_ID, L.LocationNo Location_No, L.LocationDescription Location_Description, D.DepartmentDesc Department_Desc, L.NotetoTech Note_To_Tech, L.District District, L.State State, L.Country Country FROM location L, department D WHERE L.DepartmentID=D.DepartmentID');
	//DEFINE('LOCATN','SELECT L.LocationId Location_ID, L.LocationNo Location_No, L.LocationDescription Location_Description, L.DepartmentID, L.NotetoTech Note_To_Tech, L.District District, L.State State, L.Country Country FROM location L');
	DEFINE('EDLOCATN','SELECT L.LocationId Location_ID, L.LocationNo Location_No, L.LocationDescription Location_Description, L.DepartmentID, L.NotetoTech Note_To_Tech, L.District District, L.State State, L.Country Country FROM location L');
	DEFINE('COUNTLOCATN','SELECT COUNT(*) FROM location L, department D WHERE L.DepartmentID=D.DepartmentID');
	DEFINE('ASSTAT','SELECT AssetStatusID Asset_Status_ID, AssetStatusDesc Asset_Status_Desc FROM asset_status WHERE AssetStatusID<>"AK000001"');
	DEFINE('COUNTASSTAT','SELECT COUNT(*) FROM asset_status');
	DEFINE('CRITIC','SELECT CriticalID Critical_ID, Criticaly Criticality FROM critically');
	DEFINE('COUNTCRITIC','SELECT COUNT(*) FROM critically');
	DEFINE('WARRAN','SELECT WarrantyID Warranty_ID, Warranty Warranty FROM warranty_contract');
	DEFINE('COUNTWARRAN','SELECT COUNT(*) FROM warranty_contract');
	DEFINE('WTRADE','SELECT WorkTradeID Work_Trade_ID, WorkTrade Work_Trade FROM work_trade');
	DEFINE('COUNTWTRADE','SELECT COUNT(*) FROM work_trade');
	DEFINE('PRIORY','SELECT WorkPriorityID Work_Priority_ID, WorkPriority Work_Priority FROM work_priority');
	DEFINE('COUNTPRIORY','SELECT COUNT(*) FROM work_priority');
	DEFINE('WSTATE','SELECT A.WorkStatusID Work_Status_ID, A.WorkStatus Work_Status,B.group_name Name_group,A.id_group ID_group FROM work_status A LEFT JOIN tb_user_group B ON A.id_group=B.id_group WHERE A.WorkStatusID<>"WS000001"');
	DEFINE('COUNTWSTATE','SELECT COUNT(*) FROM work_status');
	DEFINE('WRTYPE','SELECT WorkTypeID Work_Type_ID, WorkTypeDesc Work_Type FROM work_type WHERE WorkTypeID<>"WT000002"');
	DEFINE('COUNTWRTYPE','SELECT COUNT(*) FROM work_type');
	DEFINE('EMPLOY','SELECT E.EmployeeID Employee_ID, E.EmployeeNo Employee_No, E.FirstName First_Name, E.LastName Last_Name, P.PositionName Position,D.DepartmentDesc Department_Desc, E.WorkPhone Work_Phone, E.HandPhone Hand_Phone, E.Address Address, E.OfficeLocation Office_Location, E.HourlySalary Hourly_Salary, E.Overtime1 Overtime_1, E.Overtime2 Overtime_2, E.Overtime3 Overtime_3 FROM employee E, department D, position P WHERE E.DepartmentID=D.DepartmentID AND E.Positions=P.PositionID');
	DEFINE('EDEMPLOY','SELECT E.EmployeeID Employee_ID, E.EmployeeNo Employee_No, E.FirstName First_Name, E.LastName Last_Name, E.Positions ,E.DepartmentID Department_Desc, E.WorkPhone Work_Phone, E.HandPhone Hand_Phone, E.Address Address, E.OfficeLocation Office_Location, E.HourlySalary Hourly_Salary, E.Overtime1 Overtime_1, E.Overtime2 Overtime_2, E.Overtime3 Overtime_3 FROM employee E');
	DEFINE('COUNTEMPLOY','SELECT COUNT(*) FROM employee E, department D WHERE E.DepartmentID=D.DepartmentID ');
	DEFINE('SUPPLY','SELECT Supplier_ID, SupplierNo Supplier_No, SupplierName Supplier_Name, Designation, Address, PostalCode Postal_Code, City, State, Country, TelpNo Telephone_No, FaxNumber Fax_No, Service FROM supplier');
	DEFINE('COUNTSUPPLY','SELECT COUNT(*) FROM supplier');
	DEFINE('ASSETS',"SELECT A.AssetID Asset_ID, A.AssetNo Asset_No, A.AssetDesc Asset_Desc, L.LocationDescription Location_Desc, D.DepartmentDesc Department_Desc, C.AssetCategory Asset_Category, S.AssetStatusDesc Asset_Status, I.Criticaly Critically, E.FirstName Auth_Employee, P.SupplierName Supplier_Name, A.Manufacturer Manufacturer, A.ModelNumber Model_Number, A.SerialNumber Serial_Number, W.warranty Warranty, A.WarrantyNotes Warranty_Notes, A.WarrantyDate Warranty_Date, A.AssetNote Asset_Note, A.DateAcquired Date_Acquired, A.DateSold Date_Sold, A.ImagePath, A.QRPath, R.AreaCode Area_Code, T.PlantCode Plant_Code
	FROM 
	asset A, location L, department D, asset_status S, asset_category C, critically I, supplier P, warranty_contract W, employee E, area R, plant T
	WHERE 
	A.locationID=L.locationID AND A.departmentID=D.departmentID AND A.AssetStatusID=S.AssetStatusID AND A.AssetCategoryID=C.AssetCategoryID AND A.CriticalID=I.CriticalID AND A.SupplierID=P.Supplier_ID AND A.WarrantyID=W.WarrantyID AND A.EmployeeID=E.EmployeeID AND A.AreaId=R.AreaId AND A.PlantId=T.PlantId AND A.Hidden='no' AND A.departmentID LIKE '%{$_SESSION['section']}%'");
	DEFINE('ASSETSNOID','SELECT A.AssetID Asset_ID, A.AssetNo Asset_No, A.AssetDesc Asset_Desc, L.LocationDescription Location_Desc, D.DepartmentDesc Department_Desc, C.AssetCategory Asset_Category, S.AssetStatusDesc Asset_Status, I.Criticaly Critically, E.FirstName Auth_Employee, P.SupplierName Supplier_Name, A.Manufacturer Manufacturer, A.ModelNumber Model_Number, A.SerialNumber Serial_Number, W.warranty Warranty, A.WarrantyNotes Warranty_Notes, A.WarrantyDate Warranty_Date, A.AssetNote Asset_Note, A.DateAcquired Date_Acquired, A.DateSold Date_Sold, A.ImagePath, A.QRPath, R.AreaCode Area_Code, T.PlantCode Plant_Code
	FROM 
	asset A, location L, department D, asset_status S, asset_category C, critically I, supplier P, warranty_contract W, employee E, area R, plant T
	WHERE 
	A.locationID=L.locationID AND A.departmentID=D.departmentID AND A.AssetStatusID=S.AssetStatusID AND A.AssetCategoryID=C.AssetCategoryID AND A.CriticalID=I.CriticalID AND A.SupplierID=P.Supplier_ID AND A.WarrantyID=W.WarrantyID AND A.EmployeeID=E.EmployeeID AND A.AreaId=R.AreaId AND A.PlantId=T.PlantId AND A.Hidden="no"');
	DEFINE('EDASSETS','SELECT A.AssetID Asset_ID, A.AssetNo Asset_No, A.AssetDesc Asset_Desc, A.LocationID, A.DepartmentID, A.AssetCategoryID, A.AssetStatusID, A.CriticalID, A.EmployeeID, A.SupplierID, A.Manufacturer Manufacturer, A.ModelNumber Model_Number, A.SerialNumber Serial_Number, A.WarrantyID, A.WarrantyNotes Warranty_Notes, A.WarrantyDate Warranty_Date, A.AssetNote Asset_Note, A.DateAcquired Date_Acquired, A.DateSold Date_Sold, A.ParentID, A.AreaID, A.PlantID FROM asset A');
	DEFINE('COUNTASSETS','SELECT COUNT(*) FROM  asset A, location L, department D, asset_status S, asset_category C, critically I, supplier P, warranty_contract W, employee E WHERE A.locationID=L.locationID AND A.departmentID=D.departmentID AND A.AssetStatusID=S.AssetStatusID AND A.AssetCategoryID=C.AssetCategoryID AND A.CriticalID=I.CriticalID AND A.SupplierID=P.Supplier_ID AND A.WarrantyID=W.WarrantyID AND A.EmployeeID=E.EmployeeID');
	DEFINE('ACHILD','SELECT S.SiblingsID Siblings_ID, A.AssetNo Asset_No ,A.AssetDesc Asset, B.AssetNo Child_No,B.AssetDesc Child FROM asset A, asset B, siblings S WHERE A.AssetID=S.AssetID AND B.AssetID=S.ChildID');
	DEFINE('COUNTACHILD','SELECT COUNT(*) FROM siblings');
	DEFINE('PMCHEK','SELECT CheckListNo Check_List_No, CheckListName Check_List_Name, Task, id_form_checklist FROM pm_checklist');
	DEFINE('PMCHEK_DETAIL','SELECT A.CheckListNo Check_List_No, A.CheckListName Check_List_Name, A.Task, B.form_name Form_Name FROM pm_checklist A, checklist_form_name B WHERE A.id_form_checklist=B.id_form_checklist
	UNION
	SELECT A.CheckListNo Check_List_No, A.CheckListName Check_List_Name, A.Task, "" Form_Name FROM pm_checklist A WHERE A.id_form_checklist="" OR A.id_form_checklist IS NULL 
	');
	DEFINE('COUNTPMCHEK','SELECT COUNT(*) FROM pm_checklist');
	DEFINE('POSITI','SELECT PositionID Position_ID, PositionCode Position_Code, PositionName Position_Name FROM position');
	DEFINE('COUNTPOSITI','SELECT COUNT(*) FROM position ');
	DEFINE('WORDER',"SELECT WO.WorkOrderNo Work_Order_No, WO.DateReceived Receive_Date, WO.DateRequired Required_Date, WO.EstDateStart Estimated_Date_Start, WO.EstDateEnd Estimated_Date_End, WO.ActDateStart Actual_Date_Start, WO.ActDateEnd Actual_Date_End, WO.DateHandOver Hand_Over_Date, AG.FirstName Assign_to, CR.FirstName Created_By, RQ.FirstName Requestor, AE.AssetDesc Asset_Name, WT.WorkTypeDesc Work_Type, WP.WorkPriority Work_Priority, WS.WorkStatus Work_Status, WR.WorkTrade Work_Trade, FC.FailureCauseDesc Failure_Code, WO.ProblemDesc Problem_Desc, WO.CauseDescription Cause_Description, WO.ActionTaken Action_Taken, WO.PreventionTaken Prevention_Taken, WO.ImagePath, WO.QRPath, WO.id_checklist_history ID_History, AE.AssetNo Asset_No
	FROM work_order WO, employee AG, employee CR, employee RQ, asset AE, work_type WT, work_priority WP, work_status WS, work_trade WR, failure_cause FC
	WHERE WO.AssignID=AG.EmployeeID AND WO.CreatedID=CR.EmployeeID AND WO.RequestorID=RQ.EmployeeID AND WO.AssetID=AE.AssetID AND WO.WorkTypeID=WT.WorkTypeID AND WO.WorkPriorityID=WP.WorkPriorityID AND WO.WorkStatusID=WS.WorkStatusID AND WO.WorkTradeID=WR.WorkTradeID AND WO.FailureCauseID=FC.FailureCauseID AND WO.Hidden='no' AND WO.DepartmentID LIKE '%{$_SESSION['section']}%'");
	DEFINE('WORDERNOID','SELECT WO.WorkOrderNo Work_Order_No, WO.DateReceived Receive_Date, WO.DateRequired Required_Date, WO.EstDateStart Estimated_Date_Start, WO.EstDateEnd Estimated_Date_End, WO.ActDateStart Actual_Date_Start, WO.ActDateEnd Actual_Date_End, WO.DateHandOver Hand_Over_Date, AG.FirstName Assign_to, CR.FirstName Created_By, RQ.FirstName Requestor, AE.AssetDesc Asset_Name, WT.WorkTypeDesc Work_Type, WP.WorkPriority Work_Priority, WS.WorkStatus Work_Status, WR.WorkTrade Work_Trade, FC.FailureCauseDesc Failure_Code, WO.ProblemDesc Problem_Desc, WO.CauseDescription Cause_Description, WO.ActionTaken Action_Taken, WO.PreventionTaken Prevention_Taken, WO.ImagePath, WO.QRPath, WO.id_checklist_history ID_History, AE.AssetNo Asset_No
	FROM work_order WO, employee AG, employee CR, employee RQ, asset AE, work_type WT, work_priority WP, work_status WS, work_trade WR, failure_cause FC
	WHERE WO.AssignID=AG.EmployeeID AND WO.CreatedID=CR.EmployeeID AND WO.RequestorID=RQ.EmployeeID AND WO.AssetID=AE.AssetID AND WO.WorkTypeID=WT.WorkTypeID AND WO.WorkPriorityID=WP.WorkPriorityID AND WO.WorkStatusID=WS.WorkStatusID AND WO.WorkTradeID=WR.WorkTradeID AND WO.FailureCauseID=FC.FailureCauseID AND WO.Hidden="no"');
	DEFINE('EDWORDER','SELECT WO.WorkOrderNo Work_Order_No, WO.DateReceived Receive_Date, WO.DateRequired Required_Date, WO.EstDateStart Estimated_Date_Start, WO.EstDateEnd Estimated_Date_End, WO.ActDateStart Actual_Date_Start, WO.ActDateEnd Actual_Date_End, WO.DateHandOver Hand_Over_Date, WO.AcceptBy, WO.AssignID Assign_to, WO.CreatedID Created_By, WO.RequestorID Requestor, WO.AssetID Asset_Name, WO.WorkTypeID Work_Type, WO.WorkPriorityID Work_Priority, WO.WorkStatusID Work_Status, WO.WorkTradeID Work_Trade, WO.FailureCauseID Failure_Code, WO.ProblemDesc Problem_Desc, WO.CauseDescription Cause_Description, WO.ActionTaken Action_Taken, WO.PreventionTaken Prevention_Taken, WO.PMTarStartDate, WO.PMTarCompDate, WO.PMTaskID, WO.PMID, WO.DepartmentID, WO.identifyK3
	FROM work_order WO');
	DEFINE('COUNTWORDER','SELECT COUNT(*) FROM work_order');
	DEFINE('PMSCHE','SELECT PS.PM_ID, AE.AssetDesc Asset, LC.locationDescription Location, WT.WorkTrade Work_Trade, PS.PMName PM_Name, PC.CheckListName PM_Task, PS.PMState PM_State, PS.FreqUnits Frequency_Unit, PS.InitiateDate Initiate_Date, PS.TargetStartDate Target_Start_Date, PS.TargetCompDate Target_Comp_Date, PS.NextDate Next_Date FROM pm_schedule PS LEFT JOIN asset AE ON PS.AssetID=AE.AssetID LEFT JOIN location LC ON PS.locationID=LC.locationID, work_trade WT, pm_checklist PC WHERE PS.PMWOTrade=WT.WorkTradeID AND PS.ChecklistNo=PC.CheckListNo AND PS.Hidden="no"');
	DEFINE('EDPMSCHE','SELECT PS.AssetID Asset, PS.LocationID Location, PS.PMWOTrade Work_Trade, PS.PMName PM_Name, PS.ChecklistNo PM_Task, PS.PMState PM_State, PS.FreqUnits Frequency_Unit, PS.InitiateDate Initiate_Date, PS.TargetStartDate Target_Start_Date, PS.TargetCompDate Target_Comp_Date, PS.NextDate Next_Date, PS.frequency, PS.PeriodDays, PS.WorkTypeId, PS.PMGenType FROM pm_schedule PS ');
	DEFINE('COUNTPMSCHE','SELECT COUNT(*) FROM pm_schedule');
	DEFINE('QASSETDOC','SELECT AD.AssetDocID Doc_ID, AE.AssetDesc Asset_Name, AD.NameDoc Doc_Name, AD.Docpath Path FROM asset_document AD, asset AE WHERE AD.AssetID=AE.AssetID');
	DEFINE('COUNTQASSETDOC','SELECT COUNT(*) FROM asset_document');
	DEFINE('QSTEPWORK','SELECT StepofWork FROM work_order');
	DEFINE('QSPAREPART','SELECT IT.item_id Item_Code, IT.item_description Item_Name, IO.quantity Quantity FROM invent_item_work_order ISA, invent_item IT, invent_stock IO, work_order WO WHERE ISA.itemspare=IT.item_id AND IT.item_id=IO.item_id AND ISA.WorkOrderNo=WO.WorkOrderNo');
	DEFINE('QSPAREPART2','SELECT IT.item_id Item_Code, IT.item_description Item_Name, IT.Stock Quantity,ISA.request_quantity Request FROM invent_item_work_order ISA, invent_item IT, work_order WO WHERE ISA.itemspare=IT.item_id AND ISA.WorkOrderNo=WO.WorkOrderNo');
	DEFINE('QSPAREPART3','SELECT IT.item_id Item_Code, IT.item_description Item_Name, IT.Stock Quantity FROM pm_invent_checklist ISA, invent_item IT, pm_checklist PM WHERE ISA.item_id=IT.item_id AND ISA.CheckListNo=PM.CheckListNo');
	DEFINE('QMANPOWER','SELECT EMP.EmployeeID ID, EMP.EmployeeNo No_ID, EMP.FirstName Name, WM.cost_hour Cost,WM.start_date start,WM.finish_date finish FROM work_order WO, employee EMP, work_order_manpower WM WHERE WO.WorkOrderNo=WM.WorkOrderNo AND EMP.EmployeeID=WM.EmployeeID');
	DEFINE('QICHECK','SELECT id_item_check Item_Check, description Description FROM checklist_item ');
	DEFINE('QMLCHECK','SELECT A.AssetID ID, CONCAT(AssetNo," - ",AssetDesc) Asset_No , A.AssetDesc Asset FROM asset A, checklist_master M WHERE A.AssetID=M.AssetID GROUP BY A.AssetID ASC');
	DEFINE('QLCHECK','SELECT id_master_checklist ID, CONCAT(AssetNo," - ",AssetDesc) Asset, C.description Item_Check FROM asset A, checklist_item C, checklist_master M WHERE A.AssetID=M.AssetID AND C.id_item_check=M.id_item_check');
	DEFINE('EDLCHECK','SELECT id_master_checklist, AssetID, id_item_check FROM checklist_master');
	DEFINE('QFORMCK','SELECT id_form_checklist ID, form_name Form FROM checklist_form_name');
	DEFINE('QDETFORM','SELECT B.form_name Form_Name, CONCAT(D.AssetNo," - ",D.AssetDesc) Asset, C.description Item_Check FROM checklist_form_master A, checklist_form_name B, asset D, checklist_item C, checklist_master M WHERE A.id_form_checklist=B.id_form_checklist AND A.id_master_checklist=M.id_master_checklist AND D.AssetID=M.AssetID AND C.id_item_check=M.id_item_check');
	DEFINE('QDAILYC','SELECT A.id_checklist_history ID, B.form_name Form_Name, date Date FROM checklist_history A, checklist_form_name B WHERE A.id_form_checklist=B.id_form_checklist');
	DEFINE('QDAILYH','SELECT B.form_name Form_Name, CONCAT(D.AssetNo," - ",D.AssetDesc) Asset, C.description Item_Check, A.description Description, A.id_master_checklist FROM checklist_history A, checklist_form_name B, asset D, checklist_item C, checklist_master M WHERE A.id_form_checklist=B.id_form_checklist AND A.id_master_checklist=M.id_master_checklist AND D.AssetID=M.AssetID AND C.id_item_check=M.id_item_check');
	DEFINE('AREA','SELECT AreaId Area_ID, AreaCode Area_Code, AreaDescription Area_Description FROM area WHERE AreaID<>"EA000001"');
	DEFINE('PLANT','SELECT PlantId Plant_ID, PlantCode Plant_Code, PlantDescription Plant_Description FROM plant WHERE PlantID<>"PL000001"');
	
	//-----------For Combobox ---------------------------------------//
	DEFINE('LOCATNDEPART','SELECT DepartmentID, DepartmentDesc FROM department ORDER BY DepartmentID ASC');
	DEFINE('COMLOCATN','SELECT locationID, locationDescription FROM location ORDER BY locationDescription ASC');
	DEFINE('COMASSCAT','SELECT AssetCategoryID, AssetCategory FROM asset_category ORDER BY AssetCategory ASC');
	DEFINE('COMASSTAT','SELECT AssetStatusID, AssetStatusDesc FROM asset_status ORDER BY AssetStatusDesc ASC');
	DEFINE('COMCRITIC','SELECT CriticalID, Criticaly FROM critically ORDER BY Criticaly ASC');
	DEFINE('COMEMPLOY','SELECT EmployeeID, FirstName FROM employee ORDER BY EmployeeID ASC');
	DEFINE('COMSUPPLY','SELECT Supplier_ID, SupplierName FROM supplier ORDER BY Supplier_ID ASC');
	DEFINE('COMWARRAN','SELECT WarrantyID, Warranty FROM warranty_contract ORDER BY WarrantyID ASC');
	DEFINE('COMASSETS','SELECT AssetID, CONCAT(AssetNo," - ",AssetDesc) FROM asset WHERE Hidden="no" ORDER BY AssetNo, AssetDesc ASC');
	DEFINE('COMASSETSNO','SELECT AssetID, AssetNo FROM asset WHERE Hidden="no" ORDER BY AssetNo, AssetDesc ASC');
	DEFINE('COMASSETSDESC','SELECT AssetID, AssetDesc FROM asset WHERE Hidden="no" ORDER BY AssetNo, AssetDesc ASC');
	DEFINE('COMASSETS_B','SELECT AssetID, CONCAT(AssetNo," - ",AssetDesc) FROM asset WHERE Hidden="no" AND AssetID NOT IN (SELECT AssetID FROM checklist_master GROUP BY AssetID) ORDER BY AssetNo, AssetDesc ASC');
	DEFINE('COMPOSITI','SELECT PositionID, PositionName FROM position ORDER BY PositionID ASC');
	if($_SESSION['groupID']=='GROUP181120033150'){
	    DEFINE('COMWOSTAT','SELECT WorkStatusID, WorkStatus FROM work_status');
	}else{
	    DEFINE('COMWOSTAT','SELECT WorkStatusID, WorkStatus FROM work_status where id_group ="'.$_SESSION['groupID'].'" OR id_group =""');
	}

	
	DEFINE('COMWOTYPE','SELECT WorkTypeID, WorkTypeDesc FROM work_type');
	DEFINE('COMWOPRIOR','SELECT WorkPriorityID, WorkPriority FROM work_priority');
	DEFINE('COMWOTRADE','SELECT WorkTradeID, WorkTrade FROM work_trade');
	DEFINE('COMFAILURE','SELECT FailureCauseID, FailureCauseDesc FROM failure_cause');
	DEFINE('COMPMTASKL','SELECT CheckListNo, CheckListName FROM pm_checklist ORDER BY CheckListName');
	DEFINE('COMBPMGENE','SELECT PM_ID, PMName FROM pm_schedule WHERE PMState="Enable" AND Hidden="no" ORDER BY PMName ASC');
	DEFINE('COMBPMGENG','SELECT PM_ID, PMName FROM pm_schedule ORDER BY PMName ASC');
	DEFINE('COMBQICHECK','SELECT id_item_check Item_Check, description Description FROM checklist_item ORDER BY id_item_check ASC');
	DEFINE('COMBFORMCK','SELECT id_form_checklist, form_name FROM checklist_form_name ORDER BY form_name ASC');
	DEFINE('COMBAREA','SELECT AreaID, AreaCode, AreaDescription FROM area ORDER BY AreaCode ASC');
	DEFINE('COMBPLANT','SELECT PlantID, PlantCode, PlantDescription FROM plant ORDER BY PlantCode ASC');
	
	//-----------Graph Dashboard ---------------------------------------//
	DEFINE('GRAPHBYSTATE','SELECT WS.WorkStatus, COUNT(WS.WorkStatusID) FROM work_order WO, work_status WS WHERE WO.WorkStatusID=WS.WorkStatusID AND WO.Hidden="no" GROUP BY WS.WorkStatusID');
	DEFINE('GRAPHBYPERFM','SELECT MONTH(DateReceived), WS.WorkStatus, COUNT(WS.WorkStatusID) FROM work_order WO, work_status WS WHERE WO.WorkStatusID=WS.WorkStatusID AND WO.Hidden="no" GROUP BY WS.WorkStatusID, MONTH(DateReceived)');
	DEFINE('GSTATEBYYEAR','SELECT WS.WorkStatus WO_State, COUNT(*) Total FROM work_order WO, work_status WS WHERE WO.WorkStatusID=WS.WorkStatusID AND WO.Hidden="no" AND YEAR(DateReceived)=YEAR(CURDATE()) GROUP BY WO.WorkStatusID');
	DEFINE('GSTATEBYMONTH','SELECT WS.WorkStatus WO_State, COUNT(*) Total FROM work_order WO, work_status WS WHERE WO.WorkStatusID=WS.WorkStatusID AND MONTH(DateReceived)=MONTH(CURDATE()) AND YEAR(DateReceived)=YEAR(CURDATE()) AND WO.Hidden="no" GROUP BY WO.WorkStatusID');
	DEFINE('GSCHEDULEWO','SELECT "Past Due Date",COUNT(*) FROM work_order WO WHERE (WO.ActDateEnd>WO.EstDateEnd OR (DATE(NOW())>WO.EstDateEnd AND WO.ActDateEnd IS NULL)) AND WO.WorkStatusID<>"WS000002" AND WO.Hidden="no"
			UNION
			SELECT "Close Due Date",COUNT(*) FROM work_order WO WHERE WO.ActDateEnd=WO.EstDateEnd And WO.WorkStatusID<>"WS000002" AND WO.Hidden="no"
			UNION
			SELECT "Within Due Date",COUNT(*) FROM work_order WO WHERE (WO.ActDateEnd<WO.EstDateEnd OR (DATE(NOW())<WO.EstDateEnd AND WO.ActDateEnd IS NULL)) And WO.WorkStatusID<>"WS000002" AND WO.Hidden="no"');
	DEFINE('GRAPHPLNSTATE','SELECT AB.FirstName, COUNT(AB.FirstName) FROM work_order AA, employee AB WHERE AA.AssignID=AB.EmployeeID AND AA.Hidden="no" GROUP BY AB.FirstName');
	DEFINE('NOTPLANPERFORMED','SELECT WorkOrderNo WO, AssetDesc Asset, T.WorkTypeDesc Work_Type, E.FirstName Assign_To, S.WorkStatus Work_Status, ProblemDesc Description FROM work_order WO, asset A, work_status S, work_type T, employee E WHERE A.AssetID=WO.AssetID AND WO.WorkStatusID=S.WorkStatusID AND WO.AssignID=E.EmployeeID AND WO.WorkTypeID=T.WorkTypeID AND WO.Hidden="no" AND (WO.WorkStatusID="WS000010" OR WO.WorkStatusID="WS000012") ORDER BY State_modified_date, WorkOrderNo DESC');
	DEFINE('PERFORMED','SELECT WorkOrderNo WO, AssetDesc Asset, T.WorkTypeDesc Work_Type, E.FirstName Assign_To, S.WorkStatus Work_Status, ProblemDesc Description FROM work_order WO, asset A, work_status S, work_type T, employee E WHERE A.AssetID=WO.AssetID AND WO.WorkStatusID=S.WorkStatusID AND WO.AssignID=E.EmployeeID AND WO.WorkTypeID=T.WorkTypeID AND WO.Hidden="no" AND (WO.WorkStatusID="WS000014") AND YEAR(WO.ActDateEnd)=YEAR(CURRENT_DATE()) ORDER BY State_modified_date, WorkOrderNo DESC');
	DEFINE('TIMESCHEDU',"SELECT CONCAT(WT.WorkTypeDesc,' : ',WO.WorkOrderNo,' ',ProblemDesc,' for ',ASS.AssetDesc) title,DATE_FORMAT(EstDateStart,'%Y-%m-%dT%H:%i:%s') start, DATE_FORMAT(EstDateEnd,'%Y-%m-%dT%H:%i:%s') end FROM work_order WO, work_type WT, asset ASS WHERE WO.WorkTypeID=WT.WorkTypeID AND ASS.AssetID=WO.AssetID AND WO.Hidden='no' AND WO.DepartmentID ='{$_SESSION['section']}'");
	DEFINE('TIMESCHEDUNOID','SELECT CONCAT(WT.WorkTypeDesc," : ",WO.WorkOrderNo," ",ProblemDesc," for ",ASS.AssetDesc) title,DATE_FORMAT(EstDateStart,"%Y-%m-%dT%H:%i:%s") start, DATE_FORMAT(EstDateEnd,"%Y-%m-%dT%H:%i:%s") end FROM work_order WO, work_type WT, asset ASS WHERE WO.WorkTypeID=WT.WorkTypeID AND ASS.AssetID=WO.AssetID AND WO.Hidden="no"');
	
	//-----------Define global variable ----------------------------//
	unset($_SESSION['inquery']); unset($_SESSION['startdate']); unset($_SESSION['compdate']); unset($_SESSION['nextdate']); unset($_SESSION['pmid']);
	
	//----------Define for Form-------------------------------------//
	DEFINE('ASSETDOC','Document');
	DEFINE('TSTEPWORK','Step Of Work');
	DEFINE('TSPAREPART','Spare Part');
	DEFINE('TMANPOWER','Man Power');
	
	//============Declaration for Permittion Access====================
	DEFINE('_ACCESS_',get_permitted(ACCESS,'access')); 
	DEFINE('_VIEW_',get_permitted(ACCESS,'view'));
	DEFINE('_EDIT_',get_permitted(ACCESS,'edit')); 
	DEFINE('_INSERT_',get_permitted(ACCESS,'insert'));
	DEFINE('_DELETE_',get_permitted(ACCESS,'delete'));
	DEFINE('_FULL_',get_permitted(ACCESS,'full'));	
	DEFINE('_DETAIL_',get_permitted(ACCESS,'view'));
	
	
?>