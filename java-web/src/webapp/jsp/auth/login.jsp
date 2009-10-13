<%@page import="org.mvc.view.*, web.xnova.forms.*" %>
<% 
View context = (View) session.getAttribute("view");
%>
<h1>Authorization</h1>

<% if ( context.getParameter("exception") != null ) { %>
    <% Exception e = (Exception) context.getParameter("exception"); %>
    <div>
        <h4>Error:</h4>
        Class: <% out.write( e.getClass().getName() ); %><br/>
        Message: <% out.write( e.getMessage() ); %>
    </div>  
<% } %>

<%
LoginForm form = (LoginForm) context.getParameter("form");
out.write( form.render() );
%>

<a href="<% out.write( request.getContextPath() ); %>/auth/register">Not have account yet</a> or <a href="#">forgot your password</a>?