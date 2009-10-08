package org.mvc.form.decorators;

import java.util.Comparator;

public class OrderComparator implements Comparator<Decorator> {

	@Override
	public int compare(Decorator o1, Decorator o2) {
		if ( o1.getOrder() == o2.getOrder() ) {
			return 0;
		} else if ( o1.getOrder() == Decorator.ORDER_FIRST ) {
			return 1;
		} else {
			return -1;
		}
	}

}
