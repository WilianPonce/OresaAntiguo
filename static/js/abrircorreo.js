var objO = new ActiveXObject('Outlook.Application');     
var objNS = objO.GetNameSpace('MAPI');     
var mItm = objO.CreateItem(0);     
mItm.Display();     
mItm.To = p_recipient;
mItm.Subject = p_subject;
mItm.Body = p_body;     
mItm.GetInspector.WindowState = 2;