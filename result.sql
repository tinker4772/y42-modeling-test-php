WITH A as (
		SELECT `id`, `name`, `age` FROM `users`
	),
 B as (
		SELECT `id`, `name`, `age` FROM `A` WHERE `age` > 18
	  ),
 C as (
		SELECT `id`, `name`, `age` FROM `B` ORDER BY `age`, `name` DESC
	  ),
 D as (
		SELECT `id`, UPPER(`name`) as `name`, `age` FROM `C`
	  ),
 E as (
		SELECT * FROM `D` limit 100 offset 0
	  )
SELECT * FROM E;

