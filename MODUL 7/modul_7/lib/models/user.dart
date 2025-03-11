class User {
  final int userId;
  final int id;
  final String userName;
  final String title;

  User({
    required this.userName,
    required this.userId,
    required this.id,
    required this.title,
  });

  // Convert JSON to User object
  factory User.fromJson(Map<String, dynamic> json) {
    return User(
      userName: json['userName'],
      userId: json['user_id'],
      id: json['id'],
      title: json['title'],
    );
  }

  // Convert User object to JSON
  Map<String, dynamic> toJson() {
    return {'user_id': userId, 'id': id, 'title': title};
  }
}
