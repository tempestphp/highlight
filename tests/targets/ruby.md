```ruby
# A simple user model
class User < ApplicationRecord
  attr_reader :name, :email

  def initialize(name, email: nil)
    @name = name
    @email = email
  end

  def admin?
    roles.include?(:admin) && !@banned
  end

  def greeting
    "Hello, #{name}!"
  end
end
```
