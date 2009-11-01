package org.mvc.validators;

import java.util.List;

public class NotEmpty extends AbstractValidator {


    protected boolean _validate(int value) {
        return value != 0;
    }

    @Override
    protected boolean _validate(Object value) {
        return value != null;
    }

    protected boolean _validate(float value) {
        return value != 0;
    }

    protected boolean _validate(char[] value) {
        return value.length != 0;
    }

    protected boolean _validate(List<Object> value) {
        return value.size() != 0;
    }

    protected boolean _validate(String value) {
        return value.length() != 0;
    }

    @Override
    protected String _getMessage() {
        return Validator.EMPTY_VALUE_ERROR;
    }

}
