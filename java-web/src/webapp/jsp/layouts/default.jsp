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
    <div class='page'>
        <div class='head'>
            <div class='logo'>
                <h1>Project xNovae</h1>
            </div>
        </div>
        <div class='body'>
            <div class="left" style="float: left;">
                <ul>
                    <li><a href="/buildings">Buildings</a></li>
                </ul>
            </div>
            <div class='center'>
                <jsp:include page="${currentAction}"/>
            </div>
        </div>
    </div>
</body>
</html>