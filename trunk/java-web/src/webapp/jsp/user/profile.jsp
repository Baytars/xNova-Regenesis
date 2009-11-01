<%@page import="web.xnova.persistence.entities.*, org.mvc.view.*, web.xnova.forms.*" %>
<%
View vc = (View) session.getAttribute("view");
User user = (User) session.getAttribute("user");
ProfileForm form = (ProfileForm) vc.getParameter("form");
%>

<h1>Profile of <% out.write( user.getLogin() ); %></h1>
<form action='<% out.write( form.getAction() ); %>' method="POST">
    <% out.write( form.getElement("name").toString() ); %>
    <% out.write( form.getElement("lastname").toString() ); %>
    <% out.write( form.getElement("email").toString() ); %>
    
    <% out.write( form.getElement("submit").toString() ); %>
</form>