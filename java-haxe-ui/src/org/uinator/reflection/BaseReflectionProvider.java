/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

package org.uinator.reflection;

import java.lang.reflect.*;
import java.util.List;
import java.util.ArrayList;
import org.uinator.utils.*;
import org.uinator.utils.Log;

/**
 *
 * @author nikelin
 */
public class BaseReflectionProvider implements ReflectionProvider {

       public Class findClass(String name, String clsPackage) throws ClassNotFoundException {
        String path = StringUtils.toCamelCase(name, "", StringCase.UPPER);
        if (clsPackage != null) {
            path = clsPackage + '.' + path;
        }

        Class currClass = Class.forName(path);

        return currClass;
    }

    public void invokeMethod(String name, Object context, Object... args) throws NoSuchMethodException, InvocationTargetException, IllegalAccessException {
        Class cls = context.getClass();

        ArrayList<Class> argsClasses = new ArrayList<Class>();
        for (Object arg : args) {
            argsClasses.add(arg.getClass());
        }

        for (Method method : cls.getDeclaredMethods()) {
            if (method.getName().equals( name ) && checkMethodParameters(method, argsClasses)) {
                method.invoke(context, args);
                return;
            }
        }

        throw new NoSuchMethodException();
    }

    public String getActualParameterType(ParameterizedType type) {
        return type.getActualTypeArguments()[0].toString().replace("class ", "");
    }

    public boolean checkMethodParameters(Method method, List<Class> classes) {
        boolean result = false;

        int equalsCount = 0;
        for (Class parameterClass : method.getParameterTypes()) {
            for (Class cls : classes) {
                if (isParent(parameterClass, cls) || cls.getName().equals( parameterClass.getName() ) ) {
                    equalsCount++;
                    break;
                }
            }
        }

        if (equalsCount == method.getParameterTypes().length) {
            result = true;
        }

        return result;
    }

    public boolean isParent(Class parent, Class child) {
        Class pParent = parent;
        Class cParent = child;
        while (pParent != cParent && pParent != null && cParent != null) {
            // Чтобы если parent - конечный предок, метод возвращал правильный результат
            pParent = pParent.getSuperclass() != null ? pParent.getSuperclass() : pParent;
            cParent = cParent.getSuperclass();
        }

        return pParent == cParent;
    }

    public void setFieldValue(String name, Object value, Object context) throws NoSuchFieldException, IllegalAccessException {
        try {
            ( (Log)Registry.get("logger") ).write("Setting value to field " + name + " in " + value);
        } catch ( Exception e ) {
            
        }
        
        try {
            // First look for user
            this.invokeMethod("set" + StringUtils.toCamelCase(name, "", StringCase.UPPER), context, value);
        } catch (Exception e) {
            Field field = context.getClass().getDeclaredField(name);

            try {
                ( (Log)Registry.get("logger") ).write("Setting value of field " + field.getName() + " to " + value);
            } catch ( Exception s ) {
                
            }
            field.set(context, value);
        }
    }

    public Class getClassForType(ParameterizedType type) {
        Type actualType = type.getActualTypeArguments()[0];
        // Huk to get actual name of generic type class
        String actualClassName = actualType.toString().replace("class ", "");

        Class result = null;
        try {
            result = Class.forName(actualClassName);
        } catch (ClassNotFoundException e) {
            // not need in exception handling
        }

        return result;
    }

    public Object initializeField(Field field, Object context) throws IllegalAccessException, InstantiationException, NoSuchFieldException {
        Object value = field.get(context);
        if (value == null) {
            try {
                this.invokeMethod("initialize" + StringUtils.toCamelCase(field.getName(), "", StringCase.UPPER), context);
            } catch (Exception e) {
                value = field.getType().newInstance();
                field.set(context, value);
            }
        }

        return value;
    }
}
