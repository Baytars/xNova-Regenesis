<%@page import="org.mvc.view.*, web.xnova.forms.*, java.io.File" %>
<% 
View context = (View) session.getAttribute("view");
%>

<%
LoginForm form = (LoginForm) context.getParameter("loginForm");
out.write( form.render() );
%>