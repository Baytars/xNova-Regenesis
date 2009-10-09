<%@page import="org.mvc.view.*, web.xnova.forms.*" %>
<% 
View context = (View) session.getAttribute("view");
%>

<h2>Registration</h2>
<%
if ( context.getParameter("form") != null ) {
	RegisterForm form = (RegisterForm) context.getParameter("form");
	out.write( form.render() );
} else {
%>
    <h2>Unexpected exception!</h2>
   <%
}
%>