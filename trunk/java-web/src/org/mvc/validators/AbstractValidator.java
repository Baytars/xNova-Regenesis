package org.mvc.validators;

abstract public class AbstractValidator implements Validator {

    private String message;

    public String getMessage() {
        return this.message;
    }

    public boolean validate(Object value) {
        boolean result = this._validate(value);

        if (!result) {
            this.message = this._getMessage();
        }

        return result;
    }

    abstract protected String _getMessage();

    abstract protected boolean _validate(Object value);

}
