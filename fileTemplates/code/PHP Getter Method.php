#set($returnType = ": $TYPE_HINT")
## First we check against a blacklist of primitive and other common types used in documentation.
#set($nonTypeHintableTypes = ["", "mixed", "number", "void", "object", "real", "double", "resource", "null"])
#foreach($nonTypeHintableType in $nonTypeHintableTypes)
    #if ($nonTypeHintableType == $TYPE_HINT)
        #set($returnType = "")
    #end
#end
## Make sure the type hint actually looks like a legal php class name(permitting namespaces too) for future proofing reasons.
## This is important because PSR-5 is coming soon, and will allow documentation of types with syntax like SplStack<int>
#if (!$TYPE_HINT.matches('^((\\)?[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]+)+$'))
    #set($returnType = "")
#end
## Next, we check if this is using the array syntax like "MyClass[]", and type hint it as a plain array
#if ($TYPE_HINT.endsWith("[]"))
    #set($returnType = ": array")
#end
/**
 * @return ${TYPE_HINT}
 */
public ${STATIC} function ${GET_OR_IS}${NAME}()$returnType
{
#if (${STATIC} == "static")
    return self::$${FIELD_NAME};
#else
    return $this->${FIELD_NAME};
#end
