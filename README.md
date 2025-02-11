# A poor PHP test needs to pass

inside the `/tests` folder you'll find a class `MyTest` that you must fix.

It attempts to mock the `BadlyWrittenLegacyClassYouCantRefactor` but fails.

Make the test work without creating a real instance of `BadlyWrittenLegacyClassYouCantRefactor` and without changing any of the `/src` classes.

## Running the tests

1. Build the container with `./build.sh`
2. Run the test with `./runTest.sh`
