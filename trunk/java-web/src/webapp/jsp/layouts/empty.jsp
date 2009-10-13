<%@page import="org.mvc.view.*" %>
<%
View view = (View) session.getAttribute("view");
pageContext.setAttribute("currentAction", view.getParameter("action") );
%>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><% view.getParameter("pageTitle"); %></title>
</head>
<body>
    <jsp:include page="${currentAction}"/>
</body>
</html>