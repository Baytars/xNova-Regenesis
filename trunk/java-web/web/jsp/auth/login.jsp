<%@page import="org.mvc.view.*, web.xnova.forms.*" %>
<% 
View context = (View) session.getAttribute("view");
%>

<h1>Authorization</h1>
<%
LoginForm form = (LoginForm) context.getParameter("form");
out.write( form.render() );
%>

<a href="<% out.write( request.getContextPath() ); %>/auth/register">Not have account yet</a> or <a href="#">forgot your password</a>?