<%@page import="web.xnova.persistence.entities.*, org.mvc.view.*" %>
<%
View vc = (View) session.getAttribute("view");
User user = (User) vc.getParameter("user");
%>

<h1>Profile of <% out.write( user.getLogin() ); %></h1>