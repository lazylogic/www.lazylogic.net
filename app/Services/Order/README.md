# app/Services/Order

## OrderService
+ order( $order_pid, $mem_pid = null )

  주문 정보 조회

+ store( $product_type, $product_pid, $mem_pid, $options = [] );

  주문 생성

+ options( $order_pid, $mem_pid, $options = [] );

  주문 옵션

+ checkout( $order_pid, $mem_pid, $options = [] );

  주문 요청

+ complete( $order_pid, $mem_pid, $options = [] );
  
  주문 완료

+ request( $order_pid, $mem_pid, $options = [] );

  주문 취소/환불 요청

+ cancel( $order_pid, $mem_pid, $options = [] );

  주문 취소 처리

+ refund( $order_pid, $mem_pid, $options = [] );

  주문 환불 처리

## Builders
* `abstract` ClassBuilder `implements` OrderBuilder
  * ClassOrderBuilder `extends` ClassBuilder
  * OnedayOrderBuilder `extends` ClassBuilder
  * GlessonOrderBuilder `extends` ClassBuilder
* LessonOrderBuilder `implements` OrderBuilder
* PackageOrderBuilder `implements` OrderBuilder

## Makers
* ClassOrderMaker `implements` OrderMaker
  + `use` ClassOrderBuilder
  + `use` OnedayOrderBuilder
  + `use` GlessonOrderBuilder
* LessonOrderMaker `implements` OrderMaker
  + `use` LessonOrderBuilder
* PackageOrderMaker `implements` OrderMaker

## Brokers
* ClassOrderBroker `implements` OrderBroker
* `abstract` LessonBroker `implements` OrderBroker
  * GlessonOrderBroker `extends` LessonBroker
  * LessonOrderBroker `extends` LessonBroker
  * OnedayOrderBroker `extends` LessonBroker
* PackageOrderBroker `implements` OrderBroker