import 'package:flutter/material.dart';

void main() => runApp(const MyApp());

/// This is the main application widget.
class MyApp extends StatelessWidget {
  const MyApp({Key? key}) : super(key: key);
  static const String _title = 'Flutter Code Sample';

  @override
  Widget build(BuildContext context) {
    return const MaterialApp(title: _title, home: MyStatefulWidget());
  }
}

/// This is the stateful widget that the main application instantiates.
class MyStatefulWidget extends StatefulWidget {
  const MyStatefulWidget({Key? key}) : super(key: key);

  @override
  State<MyStatefulWidget> createState() => _MyStatefulWidgetState();
}

/// This is the private State class that goes with MyStatefulWidget.
class _MyStatefulWidgetState extends State<MyStatefulWidget> {
  int _selectedIndex = 0;
  String selectedValue = "Option 1"; // Nilai default dropdown

  // Daftar opsi dropdown
  final List<DropdownMenuItem<String>> dropdownItems = [
    const DropdownMenuItem(value: "Option 1", child: Text("Option 1")),
    const DropdownMenuItem(value: "Option 2", child: Text("Option 2")),
    const DropdownMenuItem(value: "Option 3", child: Text("Option 3")),
  ];

  static const TextStyle optionStyle = TextStyle(
    fontSize: 24,
    fontWeight: FontWeight.bold,
  );

  void _onItemTapped(int index) {
    setState(() {
      _selectedIndex = index;
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('BottomNavigationBar Sample')),
      body: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: <Widget>[
            Text(
              'Index $_selectedIndex: ${_getPageTitle(_selectedIndex)}',
              style: optionStyle,
            ),
            const SizedBox(height: 20),

            // DropdownButton ditambahkan di sini
            DropdownButton<String>(
              value: selectedValue,
              onChanged: (String? newValue) {
                setState(() {
                  selectedValue = newValue!;
                });
              },
              items: dropdownItems,
            ),
          ],
        ),
      ),
      bottomNavigationBar: BottomNavigationBar(
        items: const <BottomNavigationBarItem>[
          BottomNavigationBarItem(icon: Icon(Icons.home), label: 'Home'),
          BottomNavigationBarItem(
            icon: Icon(Icons.business),
            label: 'Business',
          ),
          BottomNavigationBarItem(icon: Icon(Icons.school), label: 'School'),
        ],
        currentIndex: _selectedIndex,
        selectedItemColor: Colors.amber[800],
        onTap: _onItemTapped,
      ),
    );
  }

  /// Fungsi untuk mendapatkan judul halaman berdasarkan index
  String _getPageTitle(int index) {
    switch (index) {
      case 0:
        return "Home";
      case 1:
        return "Business";
      case 2:
        return "School";
      default:
        return "";
    }
  }
}
