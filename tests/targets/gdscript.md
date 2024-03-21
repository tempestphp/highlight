```gdscript
extends CharacterBody2D
class_name GamePlayer

@export var navigation : NavigationRegion2D
@export var speed : int = 75

@onready var agent := %Agent as NavigationAgent2D

func _ready() -> void:
	agent.max_speed = speed

	agent.connect("velocity_computed", func(new_velocity: Vector2):
		# use velocity_computed so that obstacles are avoided
		if not agent.is_navigation_finished():
			velocity = new_velocity
			move_and_slide()
	)

func _physics_process(_delta) -> void:
	var next_location = agent.get_next_path_position()
	
	if global_position.distance_to(next_location) > 1:
		update_navigation()
		
		if not agent.is_navigation_finished():
			var next_move_position = agent.get_next_path_position() - global_position
			agent.velocity =  next_move_position * speed

	if Input.is_action_pressed("ui_move"):
		agent.target_position = get_global_mouse_position()

func update_navigation() -> void:
	# move the navigation region so that the player is always in the center
	navigation.global_position = global_position - (get_viewport().get_visible_rect().size / 2)
	navigation.bake_navigation_polygon()
```
