import 'package:flutter/material.dart';

void main() {
  runApp(const MyApp());
  // runApp(
  //   GridView.count(
  //     primary: false,
  //     padding: const EdgeInsets.all(20),
  //     crossAxisSpacing: 10,
  //     mainAxisSpacing: 10,
  //     crossAxisCount: 2,
  //     children: <Widget>[
  //       Container(
  //         padding: const EdgeInsets.all(8),
  //         child: const Text("He'd have you all unravel at the"),
  //         color: Colors.teal[100],
  //       ),
  //       Container(
  //         padding: const EdgeInsets.all(8),
  //         child: const Text('Heed not the rabble'),
  //         color: Colors.teal[200],
  //       ),
  //       Container(
  //         padding: const EdgeInsets.all(8),
  //         child: const Text('Sound of screams but the'),
  //         color: Colors.teal[300],
  //       ),
  //       Container(
  //         padding: const EdgeInsets.all(8),
  //         child: const Text('Who scream'),
  //         color: Colors.teal[400],
  //       ),
  //       Container(
  //         padding: const EdgeInsets.all(8),
  //         child: const Text('Revolution is coming...'),
  //         color: Colors.teal[500],
  //       ),
  //       Container(
  //         padding: const EdgeInsets.all(8),
  //         child: const Text('Revolution, they...'),
  //         color: Colors.teal[600],
  //       ),
  //     ],
  //   ),
  // );
  // runApp(
  //   GridView.count(
  //     primary: false,
  //     padding: const EdgeInsets.all(20),
  //     crossAxisSpacing: 10,
  //     mainAxisSpacing: 10,
  //     crossAxisCount: 2,
  //     children: <Widget>[
  //       Container(
  //         padding: const EdgeInsets.all(8),
  //         child: const Text("He'd have you all unravel at the"),
  //         color: Colors.teal[100],
  //       ),
  //       Container(
  //         padding: const EdgeInsets.all(8),
  //         child: const Text("He'd have you all unravel at the"),
  //         color: Colors.teal[200],
  //       ),
  //       Container(
  //         padding: const EdgeInsets.all(8),
  //         child: const Text("He'd have you all unravel at the"),
  //         color: Colors.teal[300],
  //       ),
  //       Container(
  //         padding: const EdgeInsets.all(8),
  //         child: const Text("He'd have you all unravel at the"),
  //         color: Colors.teal[400],
  //       ),
  //       Container(
  //         padding: const EdgeInsets.all(8),
  //         child: const Text("He'd have you all unravel at the"),
  //         color: Colors.teal[500],
  //       ),
  //     ],
  //   ),
  // );
}

  //Container :
  // runApp( 
  //   Center(
  //     child: Container(
  //         margin: const EdgeInsets.all(10.0),
  //         color: Colors.amber[600],
  //         width: 48.0,
  //         height: 48.0,
  //       ),
  //     ),
  // );
// }
// class MyApp extends StatelessWidget {
//   const MyApp({super.key});

//   @override
//   Widget build(BuildContext context) {
//     return Container();
//   }
// }
class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      home: Scaffold(
        body: GridView.count(
          primary: false,
          padding: const EdgeInsets.all(20),
          crossAxisSpacing: 10,
          mainAxisSpacing: 10,
          crossAxisCount: 2,
          children: <Widget>[
            Container(
              padding: const EdgeInsets.all(8),
              child: const Text("He'd have you all unravel at the"),
              color: Colors.teal[100],
            ),
            Container(
              padding: const EdgeInsets.all(8),
              child: const Text('Heed not the rabble'),
              color: Colors.teal[200],
            ),
            Container(
              padding: const EdgeInsets.all(8),
              child: const Text('Sound of screams but the'),
              color: Colors.teal[300],
            ),
            Container(
              padding: const EdgeInsets.all(8),
              child: const Text('Who scream'),
              color: Colors.teal[400],
            ),
            Container(
              padding: const EdgeInsets.all(8),
              child: const Text('Revolution is coming...'),
              color: Colors.teal[500],
            ),
            Container(
              padding: const EdgeInsets.all(8),
              child: const Text('Revolution, they...'),
              color: Colors.teal[600],
            ),
          ],
        ),
      ),
    );
  }
}